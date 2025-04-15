<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('course_section_id')->constrained();
            $table->foreignId('section_content_id')->constrained();
            $table->boolean('is_completed')->default(true);
            $table->timestamps();
            
            // Create a unique constraint to prevent duplicate entries
            $table->unique(['user_id', 'section_content_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_progress');
    }
};
