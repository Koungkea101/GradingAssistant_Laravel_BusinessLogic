<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teachers extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'teacher_id',
        'department_id',
        'employee_id',
        'specializations',
        'joined_date',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'specializations' => 'array',
        'joined_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [];

    // ============ RELATIONSHIPS ============

    /**
     * Get the user associated with the teacher.
     */
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    /**
     * Get all grading submissions graded by the teacher.
     */
    public function gradingSubmissions()
    {
        return $this->hasMany(GradingSubmissions::class, 'teacher_id', 'user_id');
    }

    /**
     * Get all classes this teacher is assigned to.
     * Using the pivot table: class_teacher
     */
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_teacher', 'teacher_id', 'class_id')
                    ->using(ClassTeacher::class)
                    ->withPivot(['course_id', 'is_primary'])
                    ->withTimestamps();
    }

    /**
     * Get all class-teacher pivot records for this teacher.
     */
    public function classAssignments()
    {
        return $this->hasMany(ClassTeacher::class, 'teacher_id');
    }

    /**
     * Get only classes where this teacher is the primary teacher.
     */
    public function primaryClasses()
    {
        return $this->classes()->wherePivot('is_primary', true);
    }

    /**
     * Get only classes where this teacher is a secondary teacher.
     */
    public function secondaryClasses()
    {
        return $this->classes()->wherePivot('is_primary', false);
    }

    /**
     * Get all courses this teacher teaches.
     */
    public function courses()
    {
        return $this->belongsToMany(Courses::class, 'class_teacher', 'teacher_id', 'course_id')
                    ->distinct();
    }

    /**
     * Check if teacher is assigned to a specific class.
     */
    public function isAssignedToClass($classId)
    {
        return $this->classes()->where('class_id', $classId)->exists();
    }

    /**
     * Check if teacher is the primary teacher for a specific class.
     */
    public function isPrimaryTeacherForClass($classId)
    {
        return $this->primaryClasses()->where('class_id', $classId)->exists();
    }

    /**
     * Get the course this teacher teaches in a specific class.
     */
    public function getCourseForClass($classId)
    {
        $assignment = $this->classAssignments()->where('class_id', $classId)->first();
        return $assignment ? $assignment->course : null;
    }
}
