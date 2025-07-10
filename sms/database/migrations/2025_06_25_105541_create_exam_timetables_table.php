<?php

// database/migrations/xxxx_xx_xx_create_exam_timetables_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamTimetablesTable extends Migration
{
    public function up()
    {
        Schema::create('exam_timetables', function (Blueprint $table) {
            $table->id();
            $table->string('dice_code'); // for school-wise filtering
            $table->string('class');
            $table->string('stream')->nullable();
            $table->string('subject');
            $table->string('exam_type'); // e.g. First Term, Final
            $table->date('exam_date');
            $table->string('shift'); // Morning or Evening
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_timetables');
    }
}
