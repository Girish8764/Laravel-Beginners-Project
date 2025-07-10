<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('dice_code', 11)->nullable();
            $table->string('rollno', 10)->nullable();
            $table->string('b_rollno', 20)->nullable();
            $table->date('admission_date')->nullable();
            $table->string('sr_no', 10)->nullable();
            $table->string('admission_class', 25)->nullable();
            $table->string('stream', 20)->nullable();
            $table->string('section', 20)->nullable();
            $table->string('medium', 20)->nullable();
            $table->string('subject1', 100)->nullable();
            $table->string('subject2', 100)->nullable();
            $table->string('subject3', 100)->nullable();
            $table->string('subject4', 100)->nullable();
            $table->string('subject5', 100)->nullable();
            $table->string('subject6', 100)->nullable();
            $table->string('subject7', 100)->nullable();
            $table->string('subject8', 100)->nullable();
            $table->string('subject9', 255)->nullable();
            $table->string('third', 50)->nullable();
            $table->string('student_name', 100)->nullable();
            $table->string('father_name', 100)->nullable();
            $table->string('mother_name', 100)->nullable();
            $table->string('grand_father', 100)->nullable();
            $table->integer('g_age')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('caste', 50)->nullable();
            $table->string('category', 20)->nullable();
            $table->string('religion', 20)->nullable();
            $table->string('aadhar', 15)->nullable();
            $table->string('pan_no', 10)->nullable();
            $table->string('f_aadhar', 12)->nullable();
            $table->date('f_dob')->nullable();
            $table->string('f_place', 100)->nullable();
            $table->string('jan_aadhar', 15)->nullable();
            $table->string('mobile', 11)->nullable();
            $table->string('gmail', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('district', 255)->nullable();
            $table->string('tehsil', 255)->nullable();
            $table->string('gram', 255)->nullable();
            $table->string('occupation', 30)->nullable();
            $table->string('income', 20)->nullable();
            $table->string('rte', 20)->nullable();
            $table->string('class1', 20)->nullable();
            $table->string('year1', 20)->nullable();
            $table->string('old_rollno1', 20)->nullable();
            $table->string('old_result1', 20)->nullable();
            $table->string('old_board1', 255)->nullable();
            $table->string('class2', 20)->nullable();
            $table->string('year2', 20)->nullable();
            $table->string('old_rollno2', 20)->nullable();
            $table->string('old_result2', 20)->nullable();
            $table->string('old_board2', 255)->nullable();
            $table->string('class3', 20)->nullable();
            $table->string('year3', 20)->nullable();
            $table->string('old_rollno3', 20)->nullable();
            $table->string('old_result3', 20)->nullable();
            $table->string('old_board3', 255)->nullable();
            $table->string('father_mother_aadhar', 20)->nullable();
            $table->string('labour_card', 20)->nullable();
            $table->string('labour_no', 20)->nullable();
            $table->string('labour_date', 20)->nullable();
            $table->string('validity_date', 20)->nullable();
            $table->string('officer_issuing', 20)->nullable();
            $table->boolean('tc')->nullable();
            $table->string('img', 255)->nullable();
            $table->integer('card')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->dateTime('date')->nullable();
            $table->text('session')->nullable();
            $table->integer('add_fee')->nullable();
            $table->integer('tution_fee')->nullable();
            $table->integer('con_fee')->nullable();
            $table->integer('total_fee')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};