<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function index()
    {
        $users = User::whereHas('tickets')
            ->with('tickets.event')
            ->get();

        return view('attendees.index', compact('users'));
    }

    public function create()
    {
        // Logic to show form for creating an attendee
    }

    public function store(Request $request)
    {
        // Logic to store a new attendee
        $attendee = User::create($request->all());
        return redirect()->route('attendee.index')->with('success', 'Attendee created successfully.');
    }

    public function show($id)
    {
        $attendee = User::with('tickets.event')->findOrFail($id);
        return view('attendees.show', compact('attendee'));
    }

    public function edit($id)
    {
        // Logic to show form for editing an attendee
        $attendee = User::with('tickets.event')->findOrFail($id);
        return view('attendees.edit', compact('attendee'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing attendee
        $attendee = User::findOrFail($id);
        $attendee->update($request->all());
        return redirect()->route('attendee.index')->with('success', 'Attendee updated successfully.');
    }

    public function destroy($id)
    {
        // Logic to delete an attendee
        user::findOrFail($id)->delete();
        return redirect()->route('attendee.index')->with('success', 'Attendee deleted successfully.');
    }
}
