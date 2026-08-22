<?php

namespace Tests\Feature;

use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Repositories\StudentRepository;
use App\Services\StudentService;
use Tests\TestCase;

class ArchitectureTest extends TestCase
{
    public function test_student_repository_interface_resolves_to_repository(): void
    {
        $repository = $this->app->make(StudentRepositoryInterface::class);

        $this->assertInstanceOf(
            StudentRepository::class,
            $repository
        );
    }

    public function test_student_service_resolves_with_repository_interface(): void
    {
        $service = $this->app->make(StudentService::class);

        $this->assertInstanceOf(
            StudentService::class,
            $service
        );
    }
}