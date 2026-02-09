<?php

namespace Database\Factories;

use App\Models\Assignments;
use App\Models\Classes;
use App\Models\Organizations;
use App\Models\Courses;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignments>
 */
class AssignmentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Assignments::class;
    public function definition(): array
    {
        return [
            'organization_id' => function() {
                return Organizations::count() > 0
                    ? Organizations::inRandomOrder()->first()->id
                    : Organizations::factory()->create()->id;
            },
            'course_id' => function() {
                return Courses::count() > 0
                    ? Courses::inRandomOrder()->first()->id
                    : Courses::factory()->create()->id;
            },
            'class_id' => function() {
                return Classes::count() > 0
                    ? Classes::inRandomOrder()->first()->id
                    : Classes::factory()->create()->id;
            },
            'created_by' => function() {
                $teacherUser = Users::where('role', 'teacher')->inRandomOrder()->first();
                return $teacherUser                    ? $teacherUser->id
                    : Users::factory()->create(['role' => 'teacher'])->id;
            },
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'type' => fake()->randomElement(['homework', 'quiz', 'exam', 'project']),
            'status' => fake()->randomElement(['draft', 'published', 'closed']),
            'total_points' => fake()->numberBetween(50, 100),
            'due_date' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'passing_score' => fake()->numberBetween(50, 70),
            'published_at' => fake()->optional()->dateTimeBetween('-1 month', 'now'),
            'due_date' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'closed_at' => fake()->optional()->dateTimeBetween('now', '+2 months'),
            'settings' => json_encode([
                'allow_late_submissions' => fake()->boolean(),
                'late_submission_penalty' => fake()->numberBetween(5, 20),
                'allow_resubmissions' => fake()->boolean(),
                'max_resubmissions' => fake()->numberBetween(1, 3),
                'grading_scale' => fake()->randomElement(['points', 'percentage', 'letter']),
            ]),
        ];
    }
}
