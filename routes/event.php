<?php 

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Routes for every inlogged user.
Route::middleware(['auth'])->group(function () {
    Route::post('/tickets/reserveer', [EventController::class, 'ticketstore'])->name('tickets.ticketstore');
});

// Routes ONLY for user user.
Route::middleware(['auth', 'check.role:user'])->group(function () {
    // Routes go here
});

// Routes ONLY for organizer user.
Route::middleware(['auth', 'check.role:organizer'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/{event}/show_user', [EventController::class, 'show_user'])->name('event.show.user');
});

// Routes ONLY for admin user.
Route::middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('/admin/events', [EventController::class, 'index_admin'])->name('admin.events.index');
});
