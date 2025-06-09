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
        Schema::table('module_exam_questions', function (Blueprint $table) {
            $table->string('theory');
            $table->string('theory_video_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('module_exam_questions', function (Blueprint $table) {
            $table->dropColumn(['theory', 'theory_video_url']);
        });
    }
};
