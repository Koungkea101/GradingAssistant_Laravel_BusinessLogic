<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Questions extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'questions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'organization_id',
        'assignment_id',
        'created_by',
        'question_text',
        'correct_answer',
        'difficulty',
        'points',
        'tags',
        'category',
        'order',
        'is_template',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'points' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    /**
     * question belongs to an assignment
     */
    public function assignment()
    {
        return $this->belongsTo(Assignments::class);
    }

    /**
     * question belongs to an organization
     */
    public function organization()
    {
        return $this->belongsTo(Organizations::class);
    }

    /**
     * question belongs to a user (creator)
     */
    public function createdBy()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    /**
     * Get all from rubric associated with the question.
     */
    public function rubrics()
    {
        return $this->hasMany(Rubrics::class);
    }

    /**
     * Get all grading submissions for the question.
     */
    public function gradingSubmissions()
    {
        return $this->hasMany(GradingSubmissions::class);
    }
    
}
