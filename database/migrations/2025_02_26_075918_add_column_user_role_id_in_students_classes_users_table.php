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
            $table->unsignedBigInteger('user_id')->nullable(false)->after('id');
            $table->unsignedBigInteger('user_role_id')->nullable(false)->after('user_id');
            $table->unsignedBigInteger('students_class_id')->nullable(false)->after('user_role_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_role_id')->references('id')->on('user_roles')->onDelete('cascade');
            $table->foreign('students_class_id')->references('id')->on('students_classes')->onDelete('cascade');
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
