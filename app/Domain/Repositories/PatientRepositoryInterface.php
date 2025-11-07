<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Patient;

interface PatientRepositoryInterface
{
    /** @return Patient[] */
    public function all(): array;
    public function find(int $id): ?Patient;
    public function create(array $data): Patient;
    public function update(int $id, array $data): ?Patient;
    public function delete(int $id): bool;
}