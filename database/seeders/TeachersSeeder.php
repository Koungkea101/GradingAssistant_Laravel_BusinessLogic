<?php

namespace Database\Seeders;

use App\Models\Teachers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeachersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $model = Teachers::class;
    public function run(): void
    {
        // Create 10 random teachers using the factory
        Teachers::factory(10)->create();
    }
}
