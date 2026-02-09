<?php

namespace Database\Factories;

use App\Models\Teachers;
use App\Models\Departments;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teachers>
 */
class TeachersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Teachers::class;
    public function definition(): array
    {
        return [
            'user_id' => function() {
                $teacherUser = Users::where('role', 'teacher')->inRandomOrder()->first();
                return $teacherUser 
                    ? $teacherUser->id 
                    : Users::factory()->create(['role' => 'teacher'])->id;
            },
            'department_id' => function() {
                return Departments::count() > 0
                    ? Departments::inRandomOrder()->first()->id
                    : Departments::factory()->create()->id;
            },
            'employee_id' => strtoupper(fake()->lexify('EMP')) . fake()->numerify('###'),
            'specializations' => json_encode(fake()->randomElements(['Mathematics', 'Science', 'Literature', 'History', 'Physical Education', 'Computer Science', 'Art', 'Music'], fake()->numberBetween(1, 3))),
            'joined_date' => fake()->date(),
        ];
    }
}
