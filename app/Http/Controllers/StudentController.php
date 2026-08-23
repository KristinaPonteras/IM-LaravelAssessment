<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    public function __construct(
        private StudentService $studentService
    ) {
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'search',
            'course',
            'status',
            'year_level',
            'per_page',
        ]);

        $students = $this->studentService->getAllStudents($filters);

        return StudentResource::collection($students);
    }


    public function store(StoreStudentRequest $request)
    {
        $student = $this->studentService->createStudent(
            $request->validated()
        );

        return response()->json([
            'message' => 'Created successfully.',
            'data' => new StudentResource($student),
        ], Response::HTTP_CREATED);
    }


    public function show(string $id)
    {
        $student = $this->studentService->getStudentById($id);

        return new StudentResource($student);
    }

    public function update(UpdateStudentRequest $request, string $id)
    {
        $student = $this->studentService->updateStudent(
            $id,
            $request->validated()
        );

        return new StudentResource($student);
    }

    public function destroy(string $id)
    {
        $this->studentService->deleteStudent($id);

        return response()->noContent();
    }
}