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
        Schema::create('teacher_class', function (Blueprint $table) {
            $table->id(); // auto-incrementing ID
            $table->string('dice_code', 11);
            $table->string('name')->nullable();
            $table->string('class', 50)->nullable();
            $table->string('stream');
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_class');
    }
};
