<?php

namespace App\Http\Controllers;

use App\Models\Eventrequest;
use Illuminate\Http\Request;
use App\Models\Venue;

class EventRequestController extends Controller
{
    public function index()
    {
        $requests = Eventrequest::all();
        return view('eventrequests.index', compact('requests'));
    }

    public function create()
    {
        $venues = Venue::all();
        return view('eventrequests.create' , compact('venues'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'venue_id' => 'required|exists:venues,id',
        ]);

        Eventrequest::create($validatedData);

        return redirect()->route('eventrequests.index')->with('success', 'Event request created successfully.');
    }

    public function show(Eventrequest $eventrequest)
    {
        return view('eventrequests.show', compact('eventrequest'));
    }

    public function edit(Eventrequest $eventrequest)
    {
        $venues = Venue::all();
        return view('eventrequests.edit', compact('eventrequest', 'venues'));
    }

    public function update(Request $request, Eventrequest $eventrequest)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'venue_id' => 'required|exists:venues,id',
        ]);

        $eventrequest->update($validatedData);

        return redirect()->route('eventrequests.index')->with('success', 'Event request updated successfully.');
    }

    public function destroy(Eventrequest $eventrequest)
    {
        $eventrequest->delete();
        return redirect()->route('eventrequests.index')->with('success', 'Event request deleted successfully.');
    }
}
