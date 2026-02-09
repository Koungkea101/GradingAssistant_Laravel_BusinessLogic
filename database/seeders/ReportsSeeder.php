<?php

namespace Database\Seeders;

use App\Models\Reports;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 random reports using the factory
        Reports::factory(20)->create();
    }
}
