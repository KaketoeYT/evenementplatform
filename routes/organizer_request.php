<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizerRequestController;

Route::get('/organizer_request', [OrganizerRequestController::class, 'index'])->name('organizer_request.index');
Route::post('/organizer_request', [OrganizerRequestController::class, 'store'])->name('organizer_request.store');

Route::middleware(['auth', 'check.role:organizer'])->group(function () {
    Route::get('/organizer_requests', [OrganizerRequestController::class, 'overview'])->name('organizer_request.overview');
    
    Route::get('/organizer_request/{application}', [OrganizerRequestController::class, 'show'])->name('organizer_request.show');
    Route::delete('/organizer_request/{application}', [OrganizerRequestController::class, 'destroy'])->name('organizer_request.destroy');

    Route::post('/organizer_request/{application}/approve', [OrganizerRequestController::class, 'approve'])->name('organizer_request.approve');
    Route::post('/organizer_request/{application}/reject', [OrganizerRequestController::class, 'reject'])->name('organizer_request.reject');
});

