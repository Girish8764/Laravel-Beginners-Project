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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('dice_code', 11)->unique();
            $table->string('school_name')->nullable();       // Instead of generic 'name'
            $table->string('Sch_code')->nullable();
            $table->string('Psp_code')->nullable();
            $table->string('School_type')->nullable();
            $table->string('Aff_year')->nullable();
            $table->string('Aff_no')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile', 10)->nullable();
            $table->string('phone', 11)->nullable();
            $table->string('medium')->nullable();
            $table->string('address')->nullable();
            $table->string('village')->nullable();
            $table->string('tehsil')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('pass')->nullable();
            $table->string('image')->nullable();
            $table->string('standrad')->nullable();
            $table->string('sec_year')->nullable();
            $table->string('sr_sec_year')->nullable();
            $table->rememberToken();
            $table->tinyInteger('user_type')->default(4)->comment('4:school');
            $table->string('status')->nullable();
            $table->string('plan')->nullable();
            $table->date('plan_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('added_by')->nullable();
            $table->string('reset_token')->nullable();
            $table->string('balance')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
