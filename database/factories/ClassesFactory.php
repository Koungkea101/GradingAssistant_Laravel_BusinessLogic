<?php

namespace Database\Factories;

use App\Models\Classes;
use App\Models\Departments;
use App\Models\Organizations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class ClassesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Classes::class;

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
            'grade_level'=> fake()->numberBetween(1, 12),
            'academic_year' => fake()->year(),
        ];
    }
}
