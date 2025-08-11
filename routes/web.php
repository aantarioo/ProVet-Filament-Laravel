<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Appointments\NewAppointmentController;

//Route::get('/', function () {
//    return Inertia::render('Welcome');
//})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('home');

    Route::get('/appointments', [NewAppointmentController::class, 'index'])->name('appointments');
    Route::post('/appointments', [NewAppointmentController::class, 'store']);

    Route::get('/myappointments', function () {
        return Inertia::render('MyAppointments');
    })->name('myappointments');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
