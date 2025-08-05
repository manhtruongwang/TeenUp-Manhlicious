<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('student-management');
    } else {
        return Inertia::render('auth/login');
    }
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('student-management');
    })->name('dashboard');

    Route::get('student-management', function () {
        return Inertia::render('student-management');
    })->name('student-management');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
