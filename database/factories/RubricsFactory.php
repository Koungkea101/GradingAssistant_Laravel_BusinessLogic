<?php

namespace Database\Factories;

use App\Models\Rubrics;
use App\Models\Organizations;
use App\Models\Questions;
use App\Models\Assignments;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rubrics>
 */
class RubricsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Rubrics::class;
    public function definition(): array
    {
        return [
            'organization_id' => function() {
                return Organizations::count() > 0
                    ? Organizations::inRandomOrder()->first()->id
                    : Organizations::factory()->create()->id;
            },
            'question_id' => function() {
                return Questions::count() > 0
                    ? Questions::inRandomOrder()->first()->id
                    : Questions::factory()->create()->id;
            },
            'assignment_id' => function() {
                return Assignments::count() > 0
                    ? Assignments::inRandomOrder()->first()->id
                    : Assignments::factory()->create()->id;
            },
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'criteria' => json_encode([
                [
                    'criterion' => fake()->sentence(),
                    'points' => fake()->numberBetween(1, 10)
                ],
                [
                    'criterion' => fake()->sentence(),
                    'points' => fake()->numberBetween(1, 10)
                ],
                [
                    'criterion' => fake()->sentence(),
                    'points' => fake()->numberBetween(1, 10)
                ]
            ]),
            'total_points' => fake()->numberBetween(10, 30),
            'is_template' => fake()->boolean(20),
        ];
    }
}
