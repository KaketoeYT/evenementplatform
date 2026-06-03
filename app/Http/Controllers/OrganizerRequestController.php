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
    public function store(OrganizerRequest $organizerRequest)
    {

        Application::create([
            // add user to store
            ...$organizerRequest->validated(),
            'user_id' => auth()->id(),
        ]);
        
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
     * Aanvraag goedkeuren
     */
    public function approve(Application $application)
    {
        $application->user->update([
            'role' => 'organizer',
        ]);

        $application->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Aanvraag goedgekeurd.');
    }

    /**
     * Aanvraag afwijzen
     */
    public function reject(Application $application)
    {
        $application->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Aanvraag afgewezen.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrganizerRequest $organizerRequest)
    {

        $organizerRequest->update($organizerRequest->validated());

        return redirect()
            ->route('organizer_request.index')
            ->with('success', 'Aanvraag succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $application->delete();

        return redirect()
            ->route('organizer_request.index')
            ->with('success', 'Aanvraag succesvol verwijderd.');
    }
}