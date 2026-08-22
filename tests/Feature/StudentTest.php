<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    private function studentData(array $overrides = []): array
    {
        return array_merge([
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'email' => 'juan@example.com',
            'age' => 20,
            'course' => 'BSIT',
            'year_level' => 2,
            'status' => 'active',
        ], $overrides);
    }

    private function createStudent(array $overrides = []): Student
    {
        return Student::create($this->studentData($overrides));
    }

    // CREATE

    public function test_successfully_creates_a_student(): void
    {
        $response = $this->postJson('/api/students', $this->studentData());

        $response->assertStatus(201)
            ->assertJsonPath('data.first_name', 'Juan')
            ->assertJsonPath('data.email', 'juan@example.com');

        $this->assertDatabaseHas('students', [
            'email' => 'juan@example.com',
        ]);
    }

    public function test_rejects_invalid_student_data(): void
    {
        $response = $this->postJson('/api/students', [
            'first_name' => '',
            'last_name' => '',
            'email' => 'not-an-email',
            'age' => 10,
            'course' => '',
            'year_level' => 5,
            'status' => 'invalid',
        ]);

        $response->assertStatus(422);
    }

    public function test_rejects_duplicate_email(): void
    {
        $this->createStudent();

        $response = $this->postJson('/api/students', $this->studentData([
            'first_name' => 'Maria',
        ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    // READ

    public function test_returns_paginated_student_list(): void
    {
        $this->createStudent(['email' => 'student1@example.com']);
        $this->createStudent(['email' => 'student2@example.com']);
        $this->createStudent(['email' => 'student3@example.com']);

        $response = $this->getJson('/api/students?per_page=2');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);

        $this->assertCount(2, $response->json('data'));
    }

    public function test_returns_a_specific_student(): void
    {
        $student = $this->createStudent();

        $response = $this->getJson("/api/students/{$student->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $student->id);
    }

    public function test_returns_404_for_nonexistent_student(): void
    {
        $response = $this->getJson('/api/students/does-not-exist');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Resource not found.',
            ]);
    }

    // UPDATE

    public function test_successfully_updates_a_student(): void
    {
        $student = $this->createStudent();

        $response = $this->putJson("/api/students/{$student->id}", [
            'first_name' => 'Maria',
            'age' => 21,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.first_name', 'Maria')
            ->assertJsonPath('data.age', 21);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'first_name' => 'Maria',
            'age' => 21,
        ]);
    }

    public function test_rejects_invalid_update_data(): void
    {
        $student = $this->createStudent();

        $response = $this->putJson("/api/students/{$student->id}", [
            'age' => 10,
        ]);

        $response->assertStatus(422);
    }

    public function test_student_can_retain_existing_email(): void
    {
        $student = $this->createStudent([
            'email' => 'existing@example.com',
        ]);

        $response = $this->putJson("/api/students/{$student->id}", [
            'first_name' => 'Updated',
            'email' => 'existing@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.email', 'existing@example.com');
    }

    // DELETE

    public function test_successfully_deletes_a_student(): void
    {
        $student = $this->createStudent();

        $response = $this->deleteJson("/api/students/{$student->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('students', [
            'id' => $student->id,
        ]);
    }

    public function test_handles_deleting_a_nonexistent_student(): void
    {
        $response = $this->deleteJson('/api/students/does-not-exist');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Resource not found.',
            ]);
    }
}