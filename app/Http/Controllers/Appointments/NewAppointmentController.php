<?php

namespace App\Http\Controllers\Appointments;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class NewAppointmentController extends Controller
{
    public function index()
    {
        return Inertia::render('Appointments');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'name_of_patient' => 'required|string|lowercase|max:255',
            'date_of_appointment' => 'required|date|date_format:Y-m-d|after_or_equal:today',
        ]);

        $appointment = Appointment::create([
            'description' => $request->description,
            'name_of_patient' => $request->name_of_patient,
            'date_of_appointment' => $request->date_of_appointment,
            'user_id' => Auth::id(),
        ]);
    }
}
