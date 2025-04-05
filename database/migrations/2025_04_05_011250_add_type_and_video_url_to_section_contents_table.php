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
        Schema::table('section_contents', function (Blueprint $table) {
            $table->enum('type', ['text', 'video'])->default('text'); // Tambahkan kolom type
            $table->string('video_url')->nullable(); // Tambahkan kolom video_url
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_contents', function (Blueprint $table) {
            $table->dropColumn(['type', 'video_url']);
        });
    }
};
