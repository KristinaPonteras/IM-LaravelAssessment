<?php

namespace App\Services;

use App\Models\Student;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentService
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository
    ) {
    }

    public function getAllStudents(array $filters = []): LengthAwarePaginator
    {
        return $this->studentRepository->getAll($filters);
    }

    public function getStudentById(string $id): Student
    {
        return $this->studentRepository->findById($id);
    }

    public function createStudent(array $data): Student
    {
        return $this->studentRepository->create($data);
    }

    public function updateStudent(string $id, array $data): Student
    {
        return $this->studentRepository->update($id, $data);
    }

    public function deleteStudent(string $id): bool
    {
        return $this->studentRepository->delete($id);
    }
}
