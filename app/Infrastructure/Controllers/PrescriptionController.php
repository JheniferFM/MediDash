<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Infrastructure\Models\Prescription;

class PrescriptionController
{
    public function index(): JsonResponse
    {
        return response()->json(Prescription::query()->orderBy('id','desc')->get());
    }

    public function show(int $id): JsonResponse
    {
        $model = Prescription::find($id);
        return $model ? response()->json($model) : response()->json(['message' => 'Not found'], 404);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'patient_id' => ['required','exists:patients,id'],
            'doctor_id' => ['required','exists:doctors,id'],
            'content' => ['required','string'],
        ]);
        $created = Prescription::create($data);
        return response()->json($created, 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $model = Prescription::find($id);
        if (!$model) return response()->json(['message' => 'Not found'], 404);
        $data = $request->validate([
            'patient_id' => ['sometimes','exists:patients,id'],
            'doctor_id' => ['sometimes','exists:doctors,id'],
            'content' => ['sometimes','string'],
        ]);
        $model->update($data);
        return response()->json($model);
    }

    public function destroy(int $id): JsonResponse
    {
        $model = Prescription::find($id);
        if (!$model) return response()->json(['message' => 'Not found'], 404);
        $model->delete();
        return response()->json([], 204);
    }
}