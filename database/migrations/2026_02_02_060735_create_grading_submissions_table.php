<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grading_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('teacher_id')->nullable()->constrained('users');

            $table->text('student_answer_text')->nullable();
            $table->string('answer_image_path')->nullable();
            $table->text('ocr_extracted_text')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->dateTime('submitted_at');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['assignment_id', 'student_id']);
            $table->index(['status', 'submitted_at']);
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading_submissions');
    }
};
