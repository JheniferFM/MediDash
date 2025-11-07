<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Patient as PatientEntity;
use App\Domain\Repositories\PatientRepositoryInterface;
use App\Infrastructure\Models\Patient;
use Illuminate\Support\Facades\Schema;

class EloquentPatientRepository implements PatientRepositoryInterface
{
    public function all(): array
    {
        $orderColumn = Schema::hasColumn('patients', 'name') ? 'name' : 'id';
        return array_map([$this, 'toEntity'], Patient::query()->orderBy($orderColumn)->get()->all());
    }

    public function find(int $id): ?PatientEntity
    {
        $model = Patient::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function create(array $data): PatientEntity
    {
        $model = Patient::create($data);
        return $this->toEntity($model);
    }

    public function update(int $id, array $data): ?PatientEntity
    {
        $model = Patient::find($id);
        if (!$model) return null;
        $model->update($data);
        return $this->toEntity($model);
    }

    public function delete(int $id): bool
    {
        $model = Patient::find($id);
        return $model ? (bool) $model->delete() : false;
    }

    private function toEntity(Patient $model): PatientEntity
    {
        return new PatientEntity(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            phone: $model->phone,
            document: $model->document,
            address: $model->address,
            birth_date: $model->birth_date,
            gender: $model->gender,
        );
    }
}