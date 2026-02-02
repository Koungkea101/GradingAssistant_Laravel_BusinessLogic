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
        Schema::create('grading_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('grading_submissions')->cascadeOnDelete();
            $table->foreignId('rubric_id')->nullable()->constrained()->nullOnDelete();

            $table->decimal('score', 5, 2);
            $table->decimal('max_score', 5, 2);
            $table->decimal('percentage', 5, 2);
            $table->text('feedback_correct')->nullable();
            $table->text('feedback_incorrect')->nullable();
            $table->text('suggestions')->nullable();
            $table->text('corrected_answer')->nullable();
            $table->json('llm_response')->nullable();
            $table->integer('processing_time_ms')->nullable();
            $table->enum('grading_method', ['ai', 'manual', 'hybrid'])->default('ai');
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['submission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading_results');
    }
};
