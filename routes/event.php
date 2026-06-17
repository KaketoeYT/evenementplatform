<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Routes ONLY for user user.
Route::middleware(['auth', 'check.role:user'])->group(function () {
    // Routes go here
});

// Routes ONLY for admin user.
Route::middleware(['auth', 'check.role:admin,organizer'])->group(function () {
    Route::get('/organizer/events', [EventController::class, 'index_admin'])->name('org.events.index');
});

// Routes for every inlogged user.
Route::middleware(['auth'])->group(function () {
    Route::post('/tickets/reserveer', [TicketController::class, 'store'])->name('tickets.ticketstore');
    Route::post('/event/afmelden', [TicketController::class, 'cancel'])->name('event.afmelden');
    Route::post('/event/{event}/favorite', [TicketController::class, 'favorite'])->name('event.favorite');
    Route::post('/events/{event}/queue', [TicketController::class, 'joinQueue'])->name('event.queue')->middleware('auth');
    Route::get('/mijn-tickets', [TicketController::class, 'mijntickets'])->name('tickets.mijntickets');
    Route::get('/claim-ticket/{event}/{user}', [TicketController::class, 'claim'])
        ->name('event.claim')
        ->middleware('signed');
});

// Routes ONLY for organizer user.
Route::middleware(['auth', 'check.role:organizer'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/{event}/show_user', [EventController::class, 'show_user'])->name('event.show.user');
    Route::post('/events/{event}/toggle-registration', [EventController::class, 'toggleRegistration'])->name('events.toggleRegistration');

});

// Routes for every user, including guests.
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
