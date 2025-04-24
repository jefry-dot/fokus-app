<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FocusSessionController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/focus', fn () => Inertia::render('Focus'))->name('focus');
    Route::post('/focus-sessions', [FocusSessionController::class, 'store']);
    Route::get('/history', [FocusSessionController::class, 'index'])->name('history');
    Route::get('/focus-form', fn () => Inertia::render('FocusForm'))->name('focus-form');

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
