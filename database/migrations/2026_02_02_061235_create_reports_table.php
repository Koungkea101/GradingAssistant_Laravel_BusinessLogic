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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('generated_by')->constrained('users');
            $table->string('name');
            $table->enum('type', ['assignment', 'student', 'class', 'custom']);
            $table->json('filters')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('format', ['pdf', 'excel', 'csv'])->default('pdf');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['organization_id', 'type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
