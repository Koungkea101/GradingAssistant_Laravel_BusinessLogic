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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_id')->nullable()->constrained();
            $table->foreignId('created_by')->constrained('users');
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['quiz', 'exam', 'homework', 'project']);
            $table->enum('status', ['draft', 'published', 'closed', 'archived'])->default('draft');
            $table->integer('total_points')->default(100);
            $table->integer('passing_score')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['organization_id', 'status', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
