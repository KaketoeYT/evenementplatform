<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class TicketController extends Controller
{
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return back()->with('success', 'Ticket verwijderd');
    }
}