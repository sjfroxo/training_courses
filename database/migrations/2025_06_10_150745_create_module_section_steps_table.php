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
        Schema::create('module_section_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_section_id')->constrained('module_sections')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('type');
            $table->json('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_section_steps');
    }
};
