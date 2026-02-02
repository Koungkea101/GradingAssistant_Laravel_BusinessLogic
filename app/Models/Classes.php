<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classes extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'classes';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'organization_id',
        'department_id',
        'name',
        'code',
        'grade_level',
        'academic_year',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'grade_level' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    /**
     * Get the organization that owns the class.
     */
    public function organization()
    {
        return $this->belongsTo(Organizations::class);
    }

    /**
     * Get the department that owns the class.
     */
    public function department()
    {
        return $this->belongsTo(Departments::class);
    }

    /**
     * Get all students enrolled in this class.
     * Using the pivot table: class_student
     */
    public function students()
    {
        return $this->belongsToMany(Users::class, 'class_student', 'class_id', 'student_id')
                    ->using(ClassStudent::class)
                    ->withPivot(['enrolled_at'])
                    ->withTimestamps();
    }

    /**
     * Get all teachers assigned to this class.
     * Using the pivot table: class_teacher
     */
    public function teachers()
    {
        return $this->belongsToMany(Users::class, 'class_teacher', 'class_id', 'teacher_id')
                    ->using(ClassTeacher::class)
                    ->withPivot(['course_id', 'is_primary'])
                    ->withTimestamps();
    }

    /**
     * Get all class-student pivot records for this class.
     */
    public function classStudents()
    {
        return $this->hasMany(ClassStudent::class, 'class_id');
    }

    /**
     * Get all class-teacher pivot records for this class.
     */
    public function classTeachers()
    {
        return $this->hasMany(ClassTeacher::class, 'class_id');
    }

    /**
     * Get the primary teacher for this class.
     */
    public function primaryTeacher()
    {
        return $this->teachers()->wherePivot('is_primary', true)->first();
    }

    /**
     * Get all courses taught in this class.
     */
    public function courses()
    {
        return $this->belongsToMany(Courses::class, 'class_teacher', 'class_id', 'course_id')
                    ->distinct();
    }

    /**
     * Get all assignments for this class.
     */
    public function assignments()
    {
        return $this->hasMany(Assignments::class);
    }

    // ============ SCOPES ============

    /**
     * Scope a query to only include classes for a specific academic year.
     */
    public function scopeForAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    /**
     * Scope a query to search classes by name or code.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%");
        });
    }

    // ============ ACCESSORS ============

    /**
     * Get the full class name with code.
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} ({$this->code})";
    }

    /**
     * Get student count.
     */
    public function getStudentCountAttribute()
    {
        return $this->students()->count();
    }

    // ============ METHODS ============

    /**
     * Enroll a student in this class.
     */
    public function enrollStudent($studentId, $enrolledAt = null)
    {
        return $this->students()->attach($studentId, [
            'enrolled_at' => $enrolledAt ?? now(),
        ]);
    }

    /**
     * Assign a teacher to this class.
     */
    public function assignTeacher($teacherId, $courseId = null, $isPrimary = false)
    {
        return $this->teachers()->attach($teacherId, [
            'course_id' => $courseId,
            'is_primary' => $isPrimary,
        ]);
    }
}
