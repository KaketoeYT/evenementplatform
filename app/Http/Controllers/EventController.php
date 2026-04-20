<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $eventsByCategory = Event::with('category', 'venue')
            ->get()
            ->groupBy(fn ($event) => $event->category->name ?? 'Uncategorized');
        
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
}