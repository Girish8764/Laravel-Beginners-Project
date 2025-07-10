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
        Schema::create('teacher_subject', function (Blueprint $table) {
            $table->id(); // This creates an auto-incrementing "id" primary key
            $table->string('dice_code', 11);
            $table->string('teacher')->nullable();
            $table->string('class', 50)->nullable();
            $table->string('stream', 50)->nullable();
            $table->string('subject', 150)->nullable();
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_subject');
    }
};
