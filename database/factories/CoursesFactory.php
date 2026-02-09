<?php

namespace Database\Factories;

use App\Models\Courses;
use App\Models\Departments;
use App\Models\Organizations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courses>
 */
class CoursesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Courses::class;
    public function definition(): array
    {
        return [
            'organization_id' => function() {
                return Organizations::count() > 0
                    ? Organizations::inRandomOrder()->first()->id
                    : Organizations::factory()->create()->id;
            },
            'department_id' => function() {
                return Departments::count() > 0
                    ? Departments::inRandomOrder()->first()->id
                    : Departments::factory()->create()->id;
            },
            'name' => fake()->word(),
            'code' => strtoupper(fake()->lexify('???')) . fake()->numerify('###'),
            'description' => fake()->optional(0.7)->sentence(12),
            'credits' => fake()->numberBetween(1, 5),
        ];
    }
}
