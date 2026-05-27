<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizerRequest;
use App\Models\Application;
use Illuminate\Http\Request;

class OrganizerRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function overview()
    {
        $requests = Application::all();

        return view('organizer_request.application_view', compact('requests'));
    }

    public function index()
    {
        return view('organizer_request.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_name' => ['nullable', 'string', 'max:255'],
            'event_type'        => ['required', 'string', 'max:255'],
            'website'           => ['nullable', 'url', 'max:255'],
            'experience'        => ['nullable', 'string'],
            'motivation'        => ['required', 'string'],
        ]);

        Application::create($validated);

        return redirect()
            ->route('organizer_request.index')
            ->with('success', 'Aanvraag succesvol verstuurd.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        return view('organizer_request.show', [
            'request' => $application,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrganizerRequest $organizerRequest)
    {
        $validated = $request->validate([
            'organization_name' => ['nullable', 'string', 'max:255'],
            'event_type'        => ['required', 'string', 'max:255'],
            'website'           => ['nullable', 'url', 'max:255'],
            'experience'        => ['nullable', 'string'],
            'motivation'        => ['required', 'string'],
        ]);

        $organizerRequest->update($validated);

        return redirect()
            ->route('organizer_request.index')
            ->with('success', 'Aanvraag succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrganizerRequest $organizerRequest)
    {
        $organizerRequest->delete();

        return redirect()
            ->route('organizer_request.index')
            ->with('success', 'Aanvraag succesvol verwijderd.');
    }
}