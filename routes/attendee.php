<?php

use App\Http\Controllers\AttendeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;


Route::middleware(['auth', 'check.role:organizer'])->group(function () {
    Route::get('/attendees', [AttendeeController::class, 'index'])->name('attendee.index');
    
    Route::get('/attendees/create', [AttendeeController::class, 'create'])->name('attendee.create');
    Route::post('/attendees', [AttendeeController::class, 'store'])->name('attendee.store');
    Route::get('/attendees/{id}/edit', [AttendeeController::class, 'edit'])->name('attendee.edit');
    Route::put('/attendees/{id}', [AttendeeController::class, 'update'])->name('attendee.update');
    Route::delete('/attendees/{id}', [AttendeeController::class, 'destroy'])->name('attendee.destroy');

    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])
        ->name('attendee.ticket.destroy');
});

Route::get('/attendees/{id}', [AttendeeController::class, 'show'])->name('attendee.show');
