<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
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
});

require __DIR__.'/auth.php';
require __DIR__.'/event.php';
require __DIR__.'/venue.php';
require __DIR__.'/rapport.php';



