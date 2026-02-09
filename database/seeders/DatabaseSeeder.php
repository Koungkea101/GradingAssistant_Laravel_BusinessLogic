<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in dependency order
        $this->call([
            // Core entities first
            OrganizationsSeeder::class,
            DepartmentsSeeder::class,
            UsersSeeder::class,
            TeachersSeeder::class,
            StudentsSeeder::class,
            ClassesSeeder::class,
            CoursesSeeder::class,
            AssignmentsSeeder::class,

            // Pivot tables last (depend on core entities)
            ClassStudentSeeder::class,
            ClassTeacherSeeder::class,
        ]);

        // Create test admin user
        Users::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);
    }
}
