<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Welcome');
//})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('home');

    Route::get('/appointments', function () {
        return Inertia::render('Appointments');
    })->name('appointments');

    Route::get('/myappointments', function () {
        return Inertia::render('MyAppointments');
    })->name('myappointments');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
