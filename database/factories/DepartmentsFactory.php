<?php

namespace Database\Factories;

use App\Models\Departments;
use App\Models\Organizations;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Departments>
 */
class DepartmentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Departments::class;

    public function definition(): array
    {
        $departments = [
            'Computer Science',
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'Engineering',
            'Business Administration',
            'English Literature',
            'History',
            'Psychology',
            'Economics',
            'Art & Design',
            'Music',
            'Education',
            'Nursing',
        ];

        $name = fake()->randomElement($departments);

        return [
            'organization_id' => function() {
                return Organizations::count() > 0
                    ? Organizations::inRandomOrder()->first()->id
                    : Organizations::factory()->create()->id;
            },
            'name' => $name,
            'code' => strtoupper(Str::substr(str_replace(' ', '', $name), 0, 3)) . fake()->unique()->numberBetween(100, 999),
            'description' => fake()->optional(0.7)->sentence(12),
        ];
    }
}
