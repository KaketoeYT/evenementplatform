<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Category;
use App\Models\Event;
use App\Models\Favorite;
use App\Models\Ticket;
use App\Models\Venue;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $eventsByCategory = Event::with('category', 'venue')
            ->get()
            ->groupBy(fn ($event) => $event->category->name ?? 'Uncategorized');

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
        $user = auth()->user();

        if ($user && $user->role === 'organizer') {
            // Organizers see only events they created
            $events = Event::with('category', 'venue')
                ->where('organizer_id', $user->id)
                ->get();
        } else {
            // Admins see all events
            $events = Event::with('category', 'venue')->get();
        }

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
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('event_images', 'public');
            $data['image_url'] = $path;
        }

        $data['organizer_id'] = Auth::id();

        Event::create($data);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show($id)
    {
        // check if the user has favorited this event
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Favorite::where('user_id', Auth::id())
                ->where('event_id', $id)
                ->exists();
        }

        $event = Event::with('venue')->withCount('tickets')->findOrFail($id);

        return view('events.show', compact('event', 'isFavorited'));
    }

    public function edit(Event $event)
    {
        if ($event->organizer_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        $venues = Venue::all();

        return view('events.edit', compact('event', 'venues', 'categories'));
    }

    public function update(EventUpdateRequest $request, Event $event)
    {
        if ($event->organizer_id !== Auth::id()) {
            abort(403);
        }

        $event->update($request->validated());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if ($event->organizer_id !== Auth::id()) {
            abort(403);
        }
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    public function show_user(Event $event)
    {
        $tickets = $event->tickets()->with('user')->get();

        return view('events.show_user', compact('event', 'tickets'));
    }

    public function toggleRegistration(Event $event)
    {
        $event->registration_closed = ! $event->registration_closed;
        $event->save();

        return back()->with('success', 'Status aangepast');
    }
}
