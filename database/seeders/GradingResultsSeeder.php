<?php

namespace Database\Seeders;

use App\Models\GradingResults;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradingResultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 random grading results using the factory
        GradingResults::factory(50)->create();
    }
}
