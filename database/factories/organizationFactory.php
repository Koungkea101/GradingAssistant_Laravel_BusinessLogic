<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organizations>
 */
class OrganizationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->randomNumber(5),
            'email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'logo' => fake()->optional()->imageUrl(200, 200, 'business'),
            'settings' => json_encode([
                'theme' => fake()->randomElement(['light', 'dark']),
                'notifications' => fake()->boolean(),
                'timezone' => fake()->timezone(),
            ]),
            'is_active' => fake()->boolean(),
        ];
    }
}
