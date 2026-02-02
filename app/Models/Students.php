<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Students extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'students';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'student_id',
        'enrollment_number',
        'enrollment_date',
        'parent_name',
        'parent_email',
        'parent_phone',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'enrollment_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    /**
     * Get the user that owns the student.
     */
    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    /**
     * Get the grading submissions for the student.
     */
    public function gradingSubmissions()
    {
        return $this->hasMany(GradingSubmissions::class, 'student_id', 'student_id');
    }

    /**
     * Get all classes this student is enrolled in.
     * Using the pivot table: class_student
     */
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_student', 'student_id', 'class_id')
                    ->using(ClassStudent::class)
                    ->withPivot(['enrolled_at'])
                    ->withTimestamps();
    }

    /**
     * Get all class-student pivot records for this student.
     */
    public function classEnrollments()
    {
        return $this->hasMany(ClassStudent::class, 'student_id');
    }

    /**
     * Check if student is enrolled in a specific class.
     */
    public function isEnrolledInClass($classId)
    {
        return $this->classes()->where('class_id', $classId)->exists();
    }

    /**
     * Get enrollment date for a specific class.
     */
    public function getEnrollmentDate($classId)
    {
        $enrollment = $this->classEnrollments()->where('class_id', $classId)->first();
        return $enrollment ? $enrollment->enrolled_at : null;
    }
}
