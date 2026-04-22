<?php

namespace App\Http\Controllers;

use App\Models\Event;

class RapportController extends Controller
{
    public function index()
    {
        $events = Event::all();

        $totalEvents = $events->count();

        // ─────────────────────────────
        // EVENTS PER MAAND
        // ─────────────────────────────

        $eventsPerMonth = [];

        foreach ($events as $event) {
            $month = $event->created_at->format('F Y');

            if (!isset($eventsPerMonth[$month])) {
                $eventsPerMonth[$month] = 0;
            }

            $eventsPerMonth[$month]++;
        }

        ksort($eventsPerMonth);

        // ─────────────────────────────
        // VIEW
        // ─────────────────────────────

        return view('rapports.index', compact(
            'totalEvents',
            'eventsPerMonth'
        ));
    }
}