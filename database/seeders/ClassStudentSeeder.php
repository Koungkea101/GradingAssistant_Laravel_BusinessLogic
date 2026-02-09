<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Classes;
use App\Models\Users;
use Carbon\Carbon;

class ClassStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all classes and students
        $classes = Classes::all();
        $students = Users::where('role', 'student')->get();

        if ($classes->isEmpty() || $students->isEmpty()) {
            $this->command->info('No classes or students found. Skipping class_student seeding.');
            return;
        }

        $pivotData = [];

        // For each class, assign random students
        foreach ($classes as $class) {
            // Randomly select 5-15 students per class
            $selectedStudents = $students->random(min(fake()->numberBetween(5, 15), $students->count()));

            foreach ($selectedStudents as $student) {
                $pivotData[] = [
                    'class_id' => $class->id,
                    'student_id' => $student->id,
                    'enrolled_at' => Carbon::now()->subDays(fake()->numberBetween(1, 90)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Remove duplicates based on class_id and student_id
        $uniquePivotData = collect($pivotData)->unique(function ($item) {
            return $item['class_id'] . '-' . $item['student_id'];
        })->values()->all();

        // Insert in chunks to avoid memory issues
        $chunks = array_chunk($uniquePivotData, 500);
        foreach ($chunks as $chunk) {
            DB::table('class_student')->insert($chunk);
        }

        $this->command->info('Class-Student relationships seeded successfully!');
    }
}
