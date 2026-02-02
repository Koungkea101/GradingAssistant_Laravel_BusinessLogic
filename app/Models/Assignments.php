<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignments extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'assignments';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'assignment_id',
        'organization_id',
        'course_id',
        'class_id',
        'created_by',
        'title',
        'description',
        'type',
        'status',
        'total_points',
        'passing_score',
        'published_at',
        'due_date',
        'closed_at',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'due_date' => 'datetime',
        'total_points' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    /**
     * assignment belongs to an organization
     */
    public function organization()
    {
        return $this->belongsTo(Organizations::class);
    }

    /**
     * Get the course that owns the assignment.
     */
    public function course()
    {
        return $this->belongsTo(Courses::class);
    }

    /**
     * Get the class that owns the assignment.
     */
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    /**
     * Get the user who created the assignment.
     */
    public function createdBy()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    /**
     * Get all rubrics for the assignment.
     */
    public function rubrics()
    {
        return $this->hasMany(Rubrics::class);
    }

    /**
     * Get all grading submissions for the assignment.
     */
    public function gradingSubmissions()
    {
        return $this->hasMany(GradingSubmissions::class);
    }
}
