<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Venue;
use App\Http\Requests\EventStoreRequest;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $eventsByCategory = Event::with('category', 'venue')
            ->get()
            ->groupBy(fn($event) => $event->category->name ?? 'Uncategorized');

        return view('events.index', compact('eventsByCategory'));
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
}
