<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Classes;
use App\Models\Users;
use App\Models\Courses;

class ClassTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all classes, teachers, and courses
        $classes = Classes::all();
        $teachers = Users::where('role', 'teacher')->get();
        $courses = Courses::all();

        if ($classes->isEmpty() || $teachers->isEmpty()) {
            $this->command->info('No classes or teachers found. Skipping class_teacher seeding.');
            return;
        }

        $pivotData = [];

        // For each class, assign teachers
        foreach ($classes as $class) {
            // Select 1-3 teachers per class
            $teacherCount = fake()->numberBetween(1, min(3, $teachers->count()));
            $selectedTeachers = $teachers->random($teacherCount);

            $isPrimaryAssigned = false;

            foreach ($selectedTeachers as $index => $teacher) {
                // First teacher is primary, others are secondary
                $isPrimary = !$isPrimaryAssigned;
                if ($isPrimary) {
                    $isPrimaryAssigned = true;
                }

                // Randomly assign a course (can be null)
                $courseId = $courses->isNotEmpty() && fake()->boolean(80)
                    ? $courses->random()->id
                    : null;

                $pivotData[] = [
                    'class_id' => $class->id,
                    'teacher_id' => $teacher->id,
                    'course_id' => $courseId,
                    'is_primary' => $isPrimary,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Remove duplicates based on class_id, teacher_id, and course_id
        $uniquePivotData = collect($pivotData)->unique(function ($item) {
            return $item['class_id'] . '-' . $item['teacher_id'] . '-' . $item['course_id'];
        })->values()->all();

        // Insert in chunks to avoid memory issues
        $chunks = array_chunk($uniquePivotData, 500);
        foreach ($chunks as $chunk) {
            DB::table('class_teacher')->insert($chunk);
        }

        $this->command->info('Class-Teacher relationships seeded successfully!');
    }
}
