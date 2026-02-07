<?php

namespace Database\Factories;

use App\Models\Users;
use App\Models\Organizations;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'phone' => fake()->phoneNumber(),
            'role' => fake()->randomElement(['admin', 'user', 'manager']),
            'organization_id' => Organizations::factory(),
            'is_active' => fake()->boolean(),
            'remember_token' => Str::random(10),
        ];
    }
}
