<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Infrastructure\Models\Appointment;

class AppointmentController
{
    public function index(): JsonResponse
    {
        return response()->json(Appointment::query()->orderBy('scheduled_at','desc')->get());
    }

    public function show(int $id): JsonResponse
    {
        $model = Appointment::find($id);
        return $model ? response()->json($model) : response()->json(['message' => 'Not found'], 404);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'patient_id' => ['required','exists:patients,id'],
            'doctor_id' => ['required','exists:doctors,id'],
            'scheduled_at' => ['required','date'],
            'status' => ['nullable','in:scheduled,completed,cancelled'],
            'notes' => ['nullable','string'],
        ]);
        $created = Appointment::create($data);
        return response()->json($created, 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $model = Appointment::find($id);
        if (!$model) return response()->json(['message' => 'Not found'], 404);
        $data = $request->validate([
            'patient_id' => ['sometimes','exists:patients,id'],
            'doctor_id' => ['sometimes','exists:doctors,id'],
            'scheduled_at' => ['sometimes','date'],
            'status' => ['nullable','in:scheduled,completed,cancelled'],
            'notes' => ['nullable','string'],
        ]);
        $model->update($data);
        return response()->json($model);
    }

    public function destroy(int $id): JsonResponse
    {
        $model = Appointment::find($id);
        if (!$model) return response()->json(['message' => 'Not found'], 404);
        $model->delete();
        return response()->json([], 204);
    }
}