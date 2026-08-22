<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'age' => fake()->numberBetween(15, 30),
            'course' => fake()->randomElement([
                'BSIT',
                'Computer Science',
                'BSIS',
            ]),
            'year_level' => fake()->numberBetween(1, 4),
            'status' => fake()->randomElement([
                'active',
                'inactive',
            ]),
        ];
    }
}