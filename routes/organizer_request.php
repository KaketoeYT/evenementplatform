<?php

use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizerRequestController;

Route::get('/organizer_request', [OrganizerRequestController::class, 'index'])->name('organizer_request.index');
Route::post('/organizer_request', [OrganizerRequestController::class, 'store'])->name('organizer_request.store');
Route::get('/organizer_request/{application}', [OrganizerRequestController::class, 'show'])->name('organizer_request.show');

Route::get('/organizer_requests', [OrganizerRequestController::class, 'overview'])->name('organizer_request.overview');