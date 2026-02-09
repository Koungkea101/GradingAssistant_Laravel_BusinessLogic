<?php

namespace Database\Seeders;

use App\Models\GradingSubmissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradingSubmissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GradingSubmissions::factory(50)->create();
    }
}
