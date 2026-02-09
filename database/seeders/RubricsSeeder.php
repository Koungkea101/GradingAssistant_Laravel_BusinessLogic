<?php

namespace Database\Seeders;

use App\Models\Rubrics;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RubricsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 random rubrics using the factory
        Rubrics::factory(20)->create();
    }
}
