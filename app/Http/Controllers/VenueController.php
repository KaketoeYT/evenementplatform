<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use App\Http\Requests\VenueStoreRequest;
use App\Http\Requests\VenueUpdateRequest;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::all();
        return view('venues.index', compact('venues'));
    }

    public function create()
    {
        $venues = Venue::all();
        return view('venues.create');
    }

    public function store(VenueStoreRequest $request) {
        Venue::create($request->validated());

        return redirect()->route('venues.index')->with('success', 'Venue created successfully.');
    }

    public function update(VenueUpdateRequest $request, $id) {
            $venue = Venue::findOrFail($id);
            $venue->update($request->validated());
    
            return redirect()->route('venues.index')->with('success', 'Venue updated successfully.');
    }

    public function show($id) {
        $venue = Venue::findOrFail($id);
        return view('venues.show', compact('venue'));
    }

    public function edit($id) {
        $venue = Venue::findOrFail($id);
        return view('venues.edit', compact('venue'));
    }

    public function destroy($id) {
        $venue = Venue::findOrFail($id);
        $venue->delete();

        return redirect()->route('venues.index')->with('success', 'Venue deleted successfully.');
    }
}
