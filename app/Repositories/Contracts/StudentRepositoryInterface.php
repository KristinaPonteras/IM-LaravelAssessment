<?php

namespace App\Repositories\Contracts;

use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface StudentRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator;

    public function findById(string $id): Student;

    public function create(array $data): Student;

    public function update(string $id, array $data): Student;

    public function delete(string $id): bool;
}