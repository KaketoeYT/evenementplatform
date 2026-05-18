<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Queues;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Haal tickets op met de bijbehorende events en locaties
        $tickets = $user->tickets()->with('event.venue')->get();

        // Haal wachtrij-inschrijvingen op en bereken positie
        $queues = Queues::where('user_id', $user->id)
                    ->with('event')
                    ->get()
                    ->map(function ($queue) {
                        $queue->position = Queues::where('event_id', $queue->event_id)
                            ->where('created_at', '<', $queue->created_at)
                            ->count() + 1;
                        return $queue;
                    });

        return view('dashboard', compact('user', 'tickets', 'queues'));
    }
}
