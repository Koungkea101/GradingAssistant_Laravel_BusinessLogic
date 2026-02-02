<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rubrics extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'rubrics';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'organization_id',
        'question_id',
        'assignment_id',
        'name',
        'description',
        'criteria',
        'total_points',
        'is_template',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'criteria' => 'array',
        'total_points' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============
    /**
     * rubric belongs to an organization
     */
    public function organization()
    {
        return $this->belongsTo(Organizations::class);
    }

    /**
     * rubric belongs to a question
     */
    public function question()
    {
        return $this->belongsTo(Questions::class);
    }

    /**
     * rubric belongs to an assignment
     */
    public function assignment()
    {
        return $this->belongsTo(Assignments::class);
    }

    /**
     * rubric has many grading results
     */
    public function gradingResults()
    {
        return $this->hasMany(GradingResults::class);
    }
}
