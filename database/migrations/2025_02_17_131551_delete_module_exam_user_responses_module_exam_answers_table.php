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
        Schema::dropIfExists('module_exam_user_responses_module_exam_answers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('module_exam_user_responses_module_exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_exam_answer_id')->constrained('module_exam_answers')->cascadeOnDelete();
            $table->foreignId('module_exam_user_response_id')->constrained('module_exam_user_responses')->cascadeOnDelete();
            $table->timestamps();
        });
    }
};
