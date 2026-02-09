<?php

namespace Database\Factories;

use App\Models\GradingSubmissions;
use App\Models\Assignments;
use App\Models\Questions;
use App\Models\Students;
use App\Models\Teachers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GradingSubmissions>
 */
class GradingSubmissionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = GradingSubmissions::class;
    public function definition(): array
    {
        return [
            'assignment_id' => function() {
                return Assignments::count() > 0
                    ? Assignments::inRandomOrder()->first()->id
                    : Assignments::factory()->create()->id;
            },
            'question_id' => function() {
                return Questions::count() > 0
                    ? Questions::inRandomOrder()->first()->id
                    : Questions::factory()->create()->id;
            },
            'student_id' => function() {
                return Students::count() > 0
                    ? Students::inRandomOrder()->first()->id
                    : Students::factory()->create()->id;
            },
            'teacher_id' => function() {
                return Teachers::count() > 0
                    ? Teachers::inRandomOrder()->first()->id
                    : Teachers::factory()->create()->id;
            },
            'student_answer_text' => fake()->paragraph(),
            'answer_image_path' => null, // Assuming no image for simplicity
            'ocr_extracted_text' => fake()->paragraph(),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'failed']),
            'submitted_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
