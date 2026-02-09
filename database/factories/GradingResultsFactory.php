<?php

namespace Database\Factories;

use App\Models\GradingResults;
use App\Models\GradingSubmissions;
use App\Models\Rubrics;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GradingResults>
 */
class GradingResultsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'submission_id' => function() {
                return GradingSubmissions::count() > 0
                    ? GradingSubmissions::inRandomOrder()->first()->id
                    : GradingSubmissions::factory()->create()->id;
            },
            'rubric_id' => function() {
                return Rubrics::count() > 0
                    ? Rubrics::inRandomOrder()->first()->id
                    : Rubrics::factory()->create()->id;
            },
            'score' => fake()->randomFloat(2, 0, 100),
            'max_score' => 100.00,
            'percentage' => function(array $attributes) {
                return $attributes['max_score'] > 0
                    ? round(($attributes['score'] / $attributes['max_score']) * 100, 2)
                    : 0.00;
            },
            'feedback_correct' => fake()->sentence(),
            'feedback_incorrect' => fake()->sentence(),
            'suggestions' => fake()->paragraph(),
            'corrected_answer' => fake()->sentence(),
            'llm_response' => ['response' => fake()->paragraph()],
            'processing_time_ms' => fake()->numberBetween(100, 5000),
            'grading_method' => fake()->randomElement(['ai', 'manual', 'hybrid']),
            'reviewed_by' => function() {
                $reviewer = Users::whereIn('role', ['teacher', 'admin'])->inRandomOrder()->first();
                return $reviewer
                    ? $reviewer->id
                    : Users::factory()->create(['role' => 'teacher'])->id;
            },
            'reviewed_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
