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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('dice_code');
            $table->string('class_code');
            $table->string('stream')->nullable();
            $table->decimal('admission_fee', 10, 2)->default(0);
            $table->decimal('tuition_fee', 10, 2)->default(0);
            $table->decimal('rte_fee', 10, 2)->default(0);
            $table->decimal('late_fee', 10, 2)->default(0);
            $table->decimal('concession_amount', 10, 2)->default(0);
            $table->decimal('total_fee', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};