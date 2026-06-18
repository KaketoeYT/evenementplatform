<?php

namespace App\Http\Controllers;

use App\Mail\NewTicketMail;
use App\Mail\QueueInvitation;
use App\Models\Event;
use App\Models\Favorite;
use App\Models\Queues;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $event = Event::with('venue')->findOrFail($request->event_id);

        // Checks die geen vergrendeling nodig hebben kunnen we meteen afhandelen.
        if ($event->registration_closed) {
            return back()->with('error', 'Aanmelding gesloten');
        }

        if (now()->isAfter($event->datetime)) {
            return back()->with('error', 'Het evenement is al begonnen.');
        }

        try {
            $ticket = DB::transaction(function () use ($request) {
                // Vergrendel de event-rij. Gelijktijdige aanmeldingen wachten nu op
                // elkaar, zodat de capaciteitscheck en het aanmaken van het ticket
                // atomair gebeuren en de laatste plek nooit dubbel wordt verkocht.
                $event = Event::with('venue')
                    ->lockForUpdate()
                    ->findOrFail($request->event_id);

                // Voorkom dat dezelfde gebruiker dubbel boekt voor dit evenement.
                $alreadyBooked = $event->tickets()
                    ->where('user_id', Auth::id())
                    ->exists();

                if ($alreadyBooked) {
                    throw new \RuntimeException('Je hebt al een ticket voor dit evenement.');
                }

                if ($event->tickets()->count() >= $event->venue->capacity) {
                    throw new \RuntimeException('Helaas, dit evenement is uitverkocht!');
                }

                $ticket = new Ticket;
                $ticket->ticket_number = 'TKT-'.strtoupper(Str::random(8)); // Maakt een unieke code
                $ticket->rank = $request->rank;
                if ($ticket->rank === 'VIP') {
                    $ticket->price = $request->entry_price * 2;
                } elseif ($ticket->rank === 'seated') {
                    $ticket->price = $request->entry_price * 0.75;
                } else {
                    $ticket->price = $request->entry_price;
                }
                $ticket->event_id = $request->event_id;
                $ticket->user_id = Auth::id(); // De ID van de ingelogde gebruiker
                $ticket->save();

                return $ticket;
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        // Mail pas versturen nadat de transactie succesvol is afgerond.
        Mail::to(Auth::user()->email)->send(new NewTicketMail($ticket));

        return redirect()->back()->with('success', 'Je plek is gereserveerd! Ticket: '.$ticket->ticket_number);
    }

    public function cancel(Request $request)
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
        if (! $ticket) {
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
            'ticket_number' => 'TKT-'.strtoupper(uniqid()), // Of hoe jij je nummers genereert
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

    public function mijntickets()
    {
        // Haal de ingelogde gebruiker op met al zijn gekoppelde events
        $events = Event::whereHas('tickets', function ($query) {
            $query->where('user_id', auth()->id());
        })
            ->orderBy('datetime', 'asc')
            ->get();

        // Stuur de events naar de Blade-view
        return view('events.myevents', compact('events'));
    }

    public function joinQueue(Request $request, $eventId)
    {
        // Controleer of de gebruiker al in de wachtrij staat om dubbele rijen te voorkomen
        $exists = Queues::where('user_id', auth()->id())
            ->where('event_id', $request->event_id)
            ->exists();

        // event check
        $event = Event::findOrFail($request->event_id);

        // Check: Is de huidige tijd later dan de starttijd van het event?
        if (now()->isAfter($event->datetime)) {
            return redirect()->back()->with('error', 'Het evenement is al begonnen of afgelopen. Je kunt je niet meer aanmelden voor de wachtrij.');
        }

        if (! $exists) {
            Queues::create([
                'user_id' => auth()->id(),
                'event_id' => $request->event_id,
            ]);

            return back()->with('success', 'Je bent toegevoegd aan de wachtrij!');
        } else {
            return back()->with('info', 'Je staat al aangemeld voor de wachtrij van dit evenement.');
        }
    }

    public function favorite($eventId)
    {
        $event = Event::findOrFail($eventId);
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $favorite = Favorite::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if ($favorite) {
            $favorite->delete();

            return back()->with('success', 'Event removed from favorites!');
        }

        Favorite::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        return back()->with('success', 'Event added to favorites!');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return back()->with('success', 'Ticket verwijderd');
    }
}
