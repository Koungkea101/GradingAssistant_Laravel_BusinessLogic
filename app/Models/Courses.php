<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courses extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'courses';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'course_id',
        'organization_id',
        'department_id',
        'name',
        'code',
        'description',
        'credits',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'credits' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    /**
     * Get the organization that owns the course.
     */
    public function organization()
    {
        return $this->belongsTo(Organizations::class);
    }

    /**
     * Get the department that owns the course.
     */
    public function department()
    {
        return $this->belongsTo(Departments::class);
    }

    /**
     * Get all assignments for the course.
     */
    public function assignments()
    {
        return $this->hasMany(Assignments::class);
    }
}
