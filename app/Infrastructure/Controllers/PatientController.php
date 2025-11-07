<?php

namespace App\Infrastructure\Controllers;

use App\Domain\Repositories\PatientRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class PatientController
{
    public function __construct(private PatientRepositoryInterface $patients) {}

    public function index(): JsonResponse
    {
        return response()->json($this->patients->all());
    }

    public function show(int $id): JsonResponse
    {
        $patient = $this->patients->find($id);
        return $patient ? response()->json($patient) : response()->json(['message' => 'Not found'], 404);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('patients', 'email')],
            'phone' => ['nullable', 'string', 'max:50'],
            'document' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
        ]);

        $created = $this->patients->create($data);
        return response()->json($created, 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('patients', 'email')->ignore($id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'document' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
        ]);

        $updated = $this->patients->update($id, $data);
        return $updated ? response()->json($updated) : response()->json(['message' => 'Not found'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $ok = $this->patients->delete($id);
        return $ok ? response()->json([], 204) : response()->json(['message' => 'Not found'], 404);
    }
}