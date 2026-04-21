<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Venue;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use Illuminate\Http\Request;
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
        $ticket->price = $request->entry_price;
        $ticket->event_id = $request->event_id;
        $ticket->user_id = Auth::id(); // De ID van de ingelogde gebruiker
        $ticket->save();



        // 3. Terugsturen met een succesmelding
        return redirect()->back()->with('success', 'Je plek is gereserveerd! Ticket: ' . $ticket->ticket_number);
    }
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function show_user(Event $event)
    {
        $tickets = $event->tickets()->with('user')->get();
        return view('events.show_user', compact('event', 'tickets'));
    }
}
