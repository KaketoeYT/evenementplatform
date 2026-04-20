<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $eventsByCategory = Event::with('category', 'venue')
            ->get()
            ->groupBy(fn ($event) => $event->category->name ?? 'Uncategorized');

        return view('events.index', compact('eventsByCategory'));
    }

    public function index_admin()
    {
        $events = Event::with('category', 'venue')->get();

        return view('events.index_admin', compact('events'));
    }
}