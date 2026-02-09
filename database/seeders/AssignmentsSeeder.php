<?php

namespace Database\Seeders;

use App\Models\Assignments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 random assignments using the factory
        Assignments::factory(20)->create();
    }
}
