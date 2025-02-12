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
        Schema::table('module_exam_answers', function (Blueprint $table) {
            $table->foreignId('module_exam_id')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('module_exam_answers', function (Blueprint $table) {
            $table->dropColumn('module_exam_id');
        });
    }
};
