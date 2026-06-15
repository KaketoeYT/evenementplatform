<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventRequestController;


Route::get('/eventrequests', [EventRequestController::class, 'index'])->name('eventrequests.index');
Route::get('/eventrequests/create', [EventRequestController::class, 'create'])->name('eventrequests.create');
Route::post('/eventrequests', [EventRequestController::class, 'store'])->name('eventrequests.store');
Route::get('/eventrequests/{eventrequest}', [EventRequestController::class, 'show'])->name('eventrequests.show');
route::get('/eventrequests/{eventrequest}/edit', [EventRequestController::class, 'edit'])->name('eventrequests.edit');
route::put('/eventrequests/{eventrequest}', [EventRequestController::class, 'update'])->name('eventrequests.update');
route::delete('/eventrequests/{eventrequest}', [EventRequestController::class, 'destroy'])->name('eventrequests.destroy');