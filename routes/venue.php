<?php 

use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');

Route::middleware('auth')->group(function () {
    Route::get('/venues/create', [VenueController::class, 'create'])->name('venues.create');
    Route::post('/venues', [VenueController::class, 'store'])->name('venues.store');
    Route::get('/venues/{venue}/edit', [VenueController::class, 'edit'])->name('venues.edit');
    Route::put('/venues/{venue}', [VenueController::class, 'update'])->name('venues.update');
    Route::delete('/venues/{venue}', [VenueController::class, 'destroy'])->name('venues.destroy');
    });

Route::get('/venues/{venue}', [VenueController::class, 'show'])->name('venues.show');