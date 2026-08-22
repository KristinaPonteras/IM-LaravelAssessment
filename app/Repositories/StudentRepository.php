<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentRepository implements StudentRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Student::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['course'])) {
            $query->where('course', $filters['course']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['year_level'])) {
            $query->where('year_level', $filters['year_level']);
        }

        $perPage = $filters['per_page'] ?? 10;

        return $query->paginate($perPage);
    }

    public function findById(string $id): Student
    {
        return Student::findOrFail($id);
    }

    public function create(array $data): Student
    {
        return Student::create($data);
    }

    public function update(string $id, array $data): Student
    {
        $student = $this->findById($id);

        $student->update($data);

        return $student;
    }

    public function delete(string $id): bool
    {
        $student = $this->findById($id);

        return $student->delete();
    }
}