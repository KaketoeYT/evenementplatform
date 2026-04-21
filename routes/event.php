<?php 

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/events', [EventController::class, 'index'])->name('events.index');

// This route is only accessible for authenticated users.
Route::middleware(['auth'])->group(function () {
    Route::post('/tickets/reserveer', [EventController::class, 'ticketstore'])->name('tickets.ticketstore');
    Route::post('/event/afmelden', [EventController::class, 'afmelden'])->name('event.afmelden');
});

// These routes are only accessible for users with the 'organizer' role.
Route::middleware(['auth', 'check.role:organizer'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });

Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');