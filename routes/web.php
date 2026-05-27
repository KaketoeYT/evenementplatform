<?php

use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizerRequestController;

// TEST
Route::get('/organizer_request', [OrganizerRequestController::class, 'index'])->name('organizer_request.index');

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});

Route::middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('administrator/user_view', [Settings\ProfileController::class, 'user_view'])->name('administrator.user.view');
    Route::post('administrator/user_view', [Settings\ProfileController::class, 'update_roles'])->name('administrator.user.update');
    Route::post('administrator/user_deactivate/{userId}', [Settings\ProfileController::class, 'deactivate_user'])->name('administrator.user.deactivate');
    Route::get('mails/password_reset/{userId}', [Settings\ProfileController::class, 'sendPasswordResetMail'])->name('mails.password_reset');

    Route::get('administrator/application_view', [OrganizerRequestController::class, 'overview'])->name('organizer_request.overview');
    Route::delete('administrator/application_view', [OrganizerRequestController::class, 'destroy'])->name('organizer_request.destroy');
});

Route::get('/attendees', [AttendeeController::class, 'index'])
    ->name('attendee.index');

Route::post('/events/{event}/toggle-registration', [EventController::class, 'toggleRegistration'])->name('events.toggleRegistration');

Route::post('administrator/user_deactivate/{userId}', [Settings\ProfileController::class, 'deactivate_user'])->name('administrator.user.deactivate');
Route::get('mails/password_reset/{userId}', [Settings\ProfileController::class, 'sendPasswordResetMail'])->name('mails.password_reset');

require __DIR__ . '/auth.php';
require __DIR__ . '/event.php';
require __DIR__ . '/venue.php';
require __DIR__ . '/rapport.php';
require __DIR__ . '/attendee.php';
require __DIR__ . '/organizer_request.php';
require __DIR__.'/category.php';
