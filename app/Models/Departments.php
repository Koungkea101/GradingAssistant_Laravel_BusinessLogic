<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departments extends Model
{
     use HasFactory, SoftDeletes;

    protected $table = 'departments';

    protected $fillable = [
        'organization_id',
        'name',
        'code',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============
    /**
     * Get the organization that owns the department.
     */
    public function organization()
    {
        return $this->belongsTo(Organizations::class);
    }

    /**
     * Get all teachers in this department.
     */
    public function teachers()
    {
        return $this->hasMany(Teachers::class);
    }

    /**
     * Get all classes in this department.
     */
    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    /**
     * Get all courses in this department.
     */
    public function courses()
    {
        return $this->hasMany(Courses::class);
    }
}
