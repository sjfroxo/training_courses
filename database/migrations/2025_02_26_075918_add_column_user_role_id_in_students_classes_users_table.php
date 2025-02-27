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
        Schema::table('students_classes_users', function (Blueprint $table) {
            $table->foreignId('students_class_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('user_role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students_classes_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['user_role_id']);
            $table->dropForeign(['students_class_id']);
            $table->dropColumn(['user_id', 'user_role_id', 'students_class_id']);
        });
    }
};
