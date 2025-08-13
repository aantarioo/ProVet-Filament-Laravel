<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Appointments\NewAppointmentController;
use App\Http\Controllers\Appointments\MyAppointmentsController;

use App\Models\Owner;

//Route::get('/', function () {
//    return Inertia::render('Welcome');
//})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        $owners = Owner::all();
        return Inertia::render('Dashboard', [
            'owners' => $owners
        ]);
    })->name('home');

    Route::get('/appointments', [NewAppointmentController::class, 'index'])->name('appointments');
    Route::post('/appointments', [NewAppointmentController::class, 'store']);

    Route::get('/myappointments', [MyAppointmentsController::class, 'index'])->name('myappointments');
    Route::put('/myappointments/{id}', [MyAppointmentsController::class, 'update'])->name('myappointments.update');
    Route::delete('/myappointments/{id}', [MyAppointmentsController::class, 'destroy'])->name('myappointments.destroy');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
