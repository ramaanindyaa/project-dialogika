<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_quizzes', function (Blueprint $table) {
            $table->json('answers')->nullable()->after('is_completed');
        });
    }

    public function down(): void
    {
        Schema::table('user_quizzes', function (Blueprint $table) {
            $table->dropColumn('answers');
        });
    }
};
