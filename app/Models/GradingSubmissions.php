<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradingSubmissions extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'grading_submissions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'assignment_id',
        'question_id',
        'student_id',
        'teacher_id',
        'student_answer_text',
        'answer_image_path',
        'ocr_extracted_text',
        'status',
        'submitted_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'submitted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    /**
     * GradingSubmission belongs to an Assignment
     */
    public function assignment()
    {
        return $this->belongsTo(Assignments::class, 'assignment_id');
    }

    /**
     * GradingSubmission belongs to a Question
     */
    public function question()
    {
        return $this->belongsTo(Questions::class, 'question_id');
    }

    /**
     * GradingSubmission belongs to a Student (User)
     */
    public function student()
    {
        return $this->belongsTo(Users::class, 'student_id');
    }

    /**
     * GradingSubmission belongs to a Teacher (User)
     */
    public function teacher()
    {
        return $this->belongsTo(Users::class, 'teacher_id');
    }

    /**
     * GradingSubmission has many GradingResults
     */
    public function results()
    {
        return $this->hasMany(GradingResults::class, 'submission_id');
    }
}
