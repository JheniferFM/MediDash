<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use App\Infrastructure\Models\Patient;
use App\Infrastructure\Models\Doctor;
use App\Infrastructure\Models\Appointment;
use App\Infrastructure\Models\Exam;

class DashboardController
{
    public function summary(): JsonResponse
    {
        $patients = Patient::count();
        $doctors = Doctor::count();
        $appointmentsScheduled = Appointment::where('status','scheduled')->count();
        $appointmentsToday = Appointment::whereDate('scheduled_at', now()->toDateString())->count();
        $examsPending = Exam::where('status','pending')->count();
        $examsScheduled = Exam::where('status','scheduled')->count();

        return response()->json([
            'patients' => $patients,
            'doctors' => $doctors,
            'appointments' => [
                'scheduled' => $appointmentsScheduled,
                'today' => $appointmentsToday,
            ],
            'exams' => [
                'pending' => $examsPending,
                'scheduled' => $examsScheduled,
            ],
        ]);
    }
}