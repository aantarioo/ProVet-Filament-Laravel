<?php

namespace App\Http\Controllers\Appointments;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Inertia\Inertia;
use Illuminate\Http\Request;

class MyAppointmentsController extends Controller
{
    public function index(Request $request)
    {
        $appointments = Appointment::orderBy('created_at', 'desc')->where('user_id', $request->user()->id)->get();;
        $appointments->transform(function ($appointment) {
            $appointment->created_at_formatted = $appointment->created_at->format('Y-m-d H:i:s');
            $appointment->updated_at_formatted = $appointment->updated_at->format('Y-m-d H:i:s');
            return $appointment;
        });

        return Inertia::render('MyAppointments', [
            'appointments' => $appointments,
        ]);
    }
}
