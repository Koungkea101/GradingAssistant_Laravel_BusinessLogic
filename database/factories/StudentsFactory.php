<?php

namespace Database\Factories;

use App\Models\Students;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Students>
 */
class StudentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Students::class;
    public function definition(): array
    {
        return [
            'user_id' => function() {
                $studentUser = Users::where('role', 'student')->inRandomOrder()->first();
                return $studentUser
                    ? $studentUser->id
                    : Users::factory()->create(['role' => 'student'])->id;
            },
            'student_id' => strtoupper(fake()->lexify('STU')) . fake()->numerify('###'),
            'enrollment_number' => strtoupper(fake()->lexify('ENR')) . fake()->numerify('#####'),
            'enrollment_date' => fake()->date(),
            'parent_name' => fake()->name(),
            'parent_email' => fake()->unique()->safeEmail(),
            'parent_phone' => fake()->phoneNumber(),
        ];
    }
}
