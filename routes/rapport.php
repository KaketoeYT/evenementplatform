<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RapportController;
Route::middleware('auth')->get('/rapports', [RapportController::class, 'index'])
    ->name('rapports');
