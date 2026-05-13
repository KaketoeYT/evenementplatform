<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredEvents = Event::with(['category', 'venue'])
            ->where('datetime', '>=', now())
            ->orderBy('datetime', 'asc')
            ->take(3)
            ->get();

        return view('welcome', compact('featuredEvents'));
    }
}
