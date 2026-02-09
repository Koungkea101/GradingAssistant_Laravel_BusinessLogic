<?php

namespace Database\Seeders;

use App\Models\Organizations;
use App\Models\Users;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 random users using the factory
        Users::factory(10)->create();

        // Create or update a specific user for testing
        Users::updateOrCreate(
            ['email' => 'testuser@example.com'],
            [
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => bcrypt('password'), // password
                'phone' => '+1-555-123-4567',
                'role' => 'admin',
                'organization_id' => Organizations::factory()->create()->id,
                'is_active' => true,
                'remember_token' => Str::random(10),
            ]
        );
    }
}
