<?php

namespace Database\Factories;

use App\Models\Reports;
use App\Models\Organizations;
use App\Models\Users;
use App\Models\Classes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reports>
 */
class ReportsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Reports::class;
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-6 months', '-1 month');
        $endDate = fake()->dateTimeBetween($startDate, 'now');

        return [
            'organization_id' => function() {
                return Organizations::count() > 0
                    ? Organizations::inRandomOrder()->first()->id
                    : Organizations::factory()->create()->id;
            },
            'generated_by' => function() {
                $user = Users::inRandomOrder()->first();
                return $user ? $user->id : Users::factory()->create()->id;
            },
            'name' => fake()->sentence(3),
            'type' => fake()->randomElement(['assignment', 'student', 'class', 'custom']),
            'filters' => json_encode([
                'date_range' => [
                    'start' => $startDate->format('Y-m-d'),
                    'end' => $endDate->format('Y-m-d')
                ],
                'grade_threshold' => fake()->numberBetween(50, 90),
                'class_id' => Classes::count() > 0
                    ? Classes::inRandomOrder()->first()->id
                    : null,
                'department_id' => null,
                'include_incomplete' => fake()->boolean(),
            ]),
            'file_path' => null, // This will be set after report generation
            'format' => fake()->randomElement(['pdf', 'excel', 'csv']),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'failed']),
        ];
    }
}
