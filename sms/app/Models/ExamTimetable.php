<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamTimetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'dice_code',
        'class',
        'stream',
        'subject',
        'exam_type',
        'exam_date',
        'shift',
        'start_time',
        'end_time',
    ];
}
