<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradingResults extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'grading_results';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'submission_id',
        'rubric_id',
        'score',
        'max_score',
        'percentage',
        'feedback_correct',
        'feedback_incorrect',
        'suggestions',
        'corrected_answer',
        'llm_response',
        'processing_time_ms',
        'grading_method',
        'reviewed_by',
        'reviewed_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'llm_response' => 'array',
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============
    /**
     * grading result belongs to a grading submission
     */
    public function submission()
    {
        return $this->belongsTo(GradingSubmissions::class, 'submission_id');
    }

    /**
     * grading result belongs to a rubric
     */
    public function rubric()
    {
        return $this->belongsTo(Rubrics::class);
    }

}
