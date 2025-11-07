<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Infrastructure\Models\Exam;
use Illuminate\Support\Facades\Schema;

class ExamController
{
    public function index(): JsonResponse
    {
        $orderColumn = Schema::hasColumn('exams', 'scheduled_date')
            ? 'scheduled_date'
            : (Schema::hasColumn('exams', 'scheduled_at')
                ? 'scheduled_at'
                : (Schema::hasColumn('exams', 'performed_date')
                    ? 'performed_date'
                    : 'id'));

        return response()->json(Exam::query()->orderBy($orderColumn, 'desc')->get());
    }

    public function show(int $id): JsonResponse
    {
        $model = Exam::find($id);
        return $model ? response()->json($model) : response()->json(['message' => 'Not found'], 404);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'patient_id' => ['required','exists:patients,id'],
            'doctor_id' => ['nullable','exists:doctors,id'],
            'type' => ['required','string','max:100'],
            'scheduled_date' => ['nullable','date'],
            'performed_date' => ['nullable','date'],
            'status' => ['nullable','in:pending,scheduled,performed,cancelled'],
            'result' => ['nullable','string'],
        ]);
        $created = Exam::create($data);
        return response()->json($created, 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $model = Exam::find($id);
        if (!$model) return response()->json(['message' => 'Not found'], 404);
        $data = $request->validate([
            'patient_id' => ['sometimes','exists:patients,id'],
            'doctor_id' => ['nullable','exists:doctors,id'],
            'type' => ['sometimes','string','max:100'],
            'scheduled_date' => ['nullable','date'],
            'performed_date' => ['nullable','date'],
            'status' => ['nullable','in:pending,scheduled,performed,cancelled'],
            'result' => ['nullable','string'],
        ]);
        $model->update($data);
        return response()->json($model);
    }

    public function destroy(int $id): JsonResponse
    {
        $model = Exam::find($id);
        if (!$model) return response()->json(['message' => 'Not found'], 404);
        $model->delete();
        return response()->json([], 204);
    }
}