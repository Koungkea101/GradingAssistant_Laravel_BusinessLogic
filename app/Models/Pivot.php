<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Student Pivot Model
 * Handles the many-to-many relationship between Classes and Students
 */
class ClassStudent extends Pivot
{
    /**
     * The table associated with the model.
     */
    protected $table = 'class_student';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'class_id',
        'student_id',
        'enrolled_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'enrolled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the class that this pivot belongs to.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Get the student that this pivot belongs to.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'student_id');
    }
}

/**
 * Class Teacher Pivot Model
 * Handles the many-to-many relationship between Classes and Teachers
 */
class ClassTeacher extends Pivot
{
    /**
     * The table associated with the model.
     */
    protected $table = 'class_teacher';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'class_id',
        'teacher_id',
        'course_id',
        'is_primary',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_primary' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the class that this pivot belongs to.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Get the teacher that this pivot belongs to.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'teacher_id');
    }

    /**
     * Get the course associated with this assignment.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    /**
     * Scope to get primary teachers only.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope to get secondary teachers only.
     */
    public function scopeSecondary($query)
    {
        return $query->where('is_primary', false);
    }
}
