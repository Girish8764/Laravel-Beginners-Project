<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id(); // `id` as primary key, auto-increment
            $table->string('dice_code', 12)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('m_name', 100)->nullable();
            $table->string('f_name', 100)->nullable();
            $table->date('dob')->nullable();
            $table->string('religion', 20)->nullable();
            $table->string('category', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('mobile', 12)->nullable();
            $table->string('aadhar', 15)->nullable();
            $table->string('gender', 10)->nullable();
            $table->date('joining')->nullable();
            $table->string('password', 255)->nullable();
            $table->string('subject', 100)->nullable();
            $table->string('accdmic', 100)->nullable();
            $table->string('pro', 100)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('img', 255)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('card')->nullable();
            $table->date('date')->nullable();
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
