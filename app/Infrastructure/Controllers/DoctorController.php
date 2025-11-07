<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Infrastructure\Models\Doctor;
use Illuminate\Support\Facades\Schema;

class DoctorController
{
    public function index(): JsonResponse
    {
        $orderColumn = Schema::hasColumn('doctors', 'name') ? 'name' : 'id';
        return response()->json(Doctor::query()->orderBy($orderColumn)->get());
    }

    public function show(int $id): JsonResponse
    {
        $doctor = Doctor::find($id);
        return $doctor ? response()->json($doctor) : response()->json(['message' => 'Not found'], 404);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:doctors,email'],
            'phone' => ['nullable','string','max:50'],
            'crm' => ['nullable','string','max:50'],
            'specialty' => ['nullable','string','max:100'],
        ]);
        $created = Doctor::create($data);
        return response()->json($created, 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $doctor = Doctor::find($id);
        if (!$doctor) return response()->json(['message' => 'Not found'], 404);
        $data = $request->validate([
            'name' => ['sometimes','string','max:255'],
            'email' => ['sometimes','email','max:255', Rule::unique('doctors','email')->ignore($id)],
            'phone' => ['nullable','string','max:50'],
            'crm' => ['nullable','string','max:50'],
            'specialty' => ['nullable','string','max:100'],
        ]);
        $doctor->update($data);
        return response()->json($doctor);
    }

    public function destroy(int $id): JsonResponse
    {
        $doctor = Doctor::find($id);
        if (!$doctor) return response()->json(['message' => 'Not found'], 404);
        $doctor->delete();
        return response()->json([], 204);
    }
}