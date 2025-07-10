<?php
// File: database/migrations/2024_01_01_000001_create_id_card_templates_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('id_card_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('orientation', ['vertical', 'horizontal'])->default('vertical');
            $table->enum('type', ['student', 'staff'])->default('student');
            $table->json('template_data'); // Store canvas design data
            $table->text('css_styles')->nullable();
            $table->integer('width')->default(350);
            $table->integer('height')->default(550);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('id_card_templates');
    }
};