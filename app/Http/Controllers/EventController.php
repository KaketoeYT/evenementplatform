<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Venue;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Mail\QueueInvitation;
use App\Models\Queues;
use App\Mail\NewTicketMail;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $eventsByCategory = Event::with('category', 'venue')
            ->get()
            ->groupBy(fn($event) => $event->category->name ?? 'Uncategorized');

        $myTickets = Ticket::with('event')
            ->where('user_id', auth()->id())
            ->whereHas('event', function ($query) {
                // groter is dan (of gelijk aan) "nu minus 2 dagen"
                $query->where('datetime', '>=', now()->subDays(2));
            })
            ->get();

        return view('events.index', compact('eventsByCategory', 'myTickets'));
    }

    public function index_admin()
    {
        $events = Event::with('category', 'venue')->get();

        return view('events.index_admin', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();
        $venues = Venue::all();


        return view('events.create', compact('categories', 'venues'));
    }

    public function store(EventStoreRequest $request)
    {
        Event::create($request->validated());

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $categories = Category::all();
        $venues = Venue::all();
        return view('events.edit', compact('event', 'venues', 'categories'));
    }

    public function update(EventUpdateRequest $request, Event $event)
    {
        $event->update($request->validated());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    public function ticketstore(Request $request)
    {

        $event = Event::with('venue')->findOrFail($request->event_id);

        // Centrale registratie check
        if (!$event->canRegister()) {

            if ($event->registration_closed) {
                return back()->with('error', 'Aanmelding gesloten');
            }

            if (now()->isAfter($event->datetime)) {
                return back()->with('error', 'Het evenement is al begonnen.');
            }

            if ($event->tickets()->count() >= $event->venue->capacity) {
                return back()->with('error', 'Helaas, dit evenement is uitverkocht!');
            }
        }


        // bestaande capaciteit check
        if ($event->tickets()->count() >= $event->venue->capacity) {
            return back()->with('error', 'Helaas, dit evenement is uitverkocht!');
        }
        // 1. Zoek het evenement en de bijbehorende venue
        $event = Event::with('venue')->findOrFail($request->event_id);

        // 2. Tel hoeveel tickets er al zijn voor dit evenement
        $currentTicketsCount = $event->tickets()->count();

        // 3. Check of er nog plek is
        if ($currentTicketsCount >= $event->venue->capacity) {
            return redirect()->back()->with('error', 'Helaas, dit evenement is uitverkocht!');
        }


        // 2. Data opslaan in de database
        $ticket = new Ticket();
        $ticket->ticket_number = 'TKT-' . strtoupper(Str::random(8)); // Maakt een unieke code
        $ticket->rank = $request->rank;
        if ($ticket->rank === 'VIP') {
            $ticket->price = $request->entry_price * 2;
        }
        if ($ticket->rank === 'seated')
            {
            $ticket->price = $request->entry_price * 0.75;
        }
        else {
            $ticket->price = $request->entry_price;
        }
        $ticket->event_id = $request->event_id;
        $ticket->user_id = Auth::id(); // De ID van de ingelogde gebruiker
        $ticket->save();

        //3. Mail sturen naar de gebruiker
        Mail::to(Auth::user()->email)->send(new NewTicketMail($ticket));

        // 4. Terugsturen met een succesmelding
        return redirect()->back()->with('success', 'Je plek is gereserveerd! Ticket: ' . $ticket->ticket_number);
    }

    public function show($id)
    {
        $event = Event::with('venue')->withCount('tickets')->findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function afmelden(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $event = Event::findOrFail($request->event_id);

        // Check: Is de huidige tijd later dan de starttijd van het event?
        if (now()->isAfter($event->datetime)) {
            return redirect()->back()->with('error', 'Het evenement is al begonnen of afgelopen. Je kunt je niet meer afmelden.');
        }


        // 2. Zoek het ticket dat hoort bij de ingelogde gebruiker EN het gekozen event
        $ticket = Ticket::where('event_id', $request->event_id)
            ->where('user_id', Auth::id())
            ->first();

        // 3. Controleer of het ticket wel bestaat
        if (!$ticket) {
            return redirect()->back()->with('error', 'Je hebt geen actieve aanmelding voor dit evenement.');
        }

        $ticketNumber = $ticket->ticket_number;

        // 4. Verwijder het ticket uit de database
        $ticket->delete();

        // 2. Zoek de eerste persoon in de wachtrij die nog niet uitgenodigd is
        $nextInQueue = Queues::where('event_id', $event->id)
            ->whereNull('invited_at') // Alleen mensen die nog geen mail gehad hebben
            ->orderBy('created_at', 'asc')
            ->first();


        if ($nextInQueue) {
            // Genereer de beveiligde link (24 uur geldig)
            $url = URL::temporarySignedRoute(
                'event.claim',
                now()->addHours(24),
                ['event' => $event->id, 'user' => $nextInQueue->user_id]
            );

            // Update de database zodat we weten dat deze persoon een uitnodiging heeft
            $nextInQueue->update(['invited_at' => now()]);

            // Verstuur de mail via Mailtrap
            Mail::to($nextInQueue->user->email)->send(new QueueInvitation($url, $event));
        }

        // 5. Stuur de gebruiker terug met een succesmelding
        return redirect()->back()->with('success', "Je ticket {$ticketNumber} is succesvol afgemeld. Je plek is nu weer beschikbaar voor anderen.");
    }

    public function show_user(Event $event)
    {
        $tickets = $event->tickets()->with('user')->get();
        return view('events.show_user', compact('event', 'tickets'));
    }

    public function joinQueue(Request $request, $eventId)
    {
        // Controleer of de gebruiker al in de wachtrij staat om dubbele rijen te voorkomen
        $exists = Queues::where('user_id', auth()->id())
            ->where('event_id', $request->event_id)
            ->exists();

        //event check
        $event = Event::findOrFail($request->event_id);

        // Check: Is de huidige tijd later dan de starttijd van het event?
        if (now()->isAfter($event->datetime)) {
            return redirect()->back()->with('error', 'Het evenement is al begonnen of afgelopen. Je kunt je niet meer aanmelden voor de wachtrij.');
        }

        if (!$exists) {
            Queues::create([
                'user_id' => auth()->id(),
                'event_id' => $request->event_id,
            ]);

            return back()->with('success', 'Je bent toegevoegd aan de wachtrij!');
        } else {
            return back()->with('info', 'Je staat al aangemeld voor de wachtrij van dit evenement.');
        }
    }

    public function toggleRegistration(Event $event)
    {
        $event->registration_closed = !$event->registration_closed;
        $event->save();

        return back()->with('success', 'Status aangepast');
    }

    public function claim($eventId, $userId)
    {
        // 1. Haal het event op en tel de huidige tickets
        $event = Event::withCount('tickets')->findOrFail($eventId);

        // 2. Dubbele check: Is er nog wel plek? 
        // (Voor het geval iemand anders net het allerlaatste plekje heeft gepakt)
        if ($event->tickets_count >= $event->venue->capacity) {
            return redirect()->route('events.show', $eventId)
                ->with('error', 'Helaas, de beschikbare plek is inmiddels al door iemand anders geclaimd.');
        }

        // 3. Maak het ticket aan voor de nieuwe eigenaar
        Ticket::create([
            'user_id' => $userId,
            'event_id' => $eventId,
            'ticket_number' => 'TKT-' . strtoupper(uniqid()), // Of hoe jij je nummers genereert
            'rank' => 'Standard', // Of een andere default waarde
            'price' => $event->entry_price, // Of een andere prijs logica
        ]);

        // 4. Verwijder de gebruiker uit de wachtrij
        // Ze hebben nu immers een ticket, dus ze hoeven niet meer te wachten.
        Queues::where('event_id', $eventId)
            ->where('user_id', $userId)
            ->delete();

        return redirect()->route('events.show', $eventId)
            ->with('success', 'Gefeliciteerd! Je hebt je ticket succesvol geclaimd.');
    }
}
