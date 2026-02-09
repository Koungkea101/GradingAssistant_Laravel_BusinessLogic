<?php

namespace Database\Factories;

use App\Models\Questions;
use App\Models\Organizations;
use App\Models\Assignments;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Questions>
 */
class QuestionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Questions::class;
    public function definition(): array
    {
        return [
            'organization_id' => function() {
                return Organizations::count() > 0
                    ? Organizations::inRandomOrder()->first()->id
                    : Organizations::factory()->create()->id;
            },
            'assignment_id' => function() {
                return Assignments::count() > 0
                    ? Assignments::inRandomOrder()->first()->id
                    : Assignments::factory()->create()->id;
            },
            'created_by' => function() {
                $teacherUser = Users::where('role', 'teacher')->inRandomOrder()->first();
                return $teacherUser
                    ? $teacherUser->id
                    : Users::factory()->create(['role' => 'teacher'])->id;
            },
            'question_text' => fake()->sentence(),
            'correct_answer' => fake()->word(),
            'difficulty' => fake()->randomElement(['easy', 'medium', 'hard']),
            'points' => fake()->numberBetween(1, 100),
            'tags' => json_encode(fake()->randomElements(['algebra', 'geometry', 'calculus', 'literature', 'history', 'science'], fake()->numberBetween(1, 3))),
            'category' => fake()->randomElement(['multiple_choice', 'short_answer', 'essay']),
            'order' => fake()->numberBetween(1, 10),
            'is_template' => fake()->boolean(20), // 20% chance to be a template question
            
        ];
    }
}
