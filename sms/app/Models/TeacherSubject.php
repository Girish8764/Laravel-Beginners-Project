<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    use HasFactory;

    protected $table = 'teacher_subject';

    protected $fillable = [
        'dice_code',
        'teacher',
        'class',
        'stream',
        'subject',
    ];
}
