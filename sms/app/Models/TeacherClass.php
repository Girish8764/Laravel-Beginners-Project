<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherClass extends Model
{
    use HasFactory;

    protected $table = 'teacher_class';

    protected $fillable = [
        'dice_code', 'name', 'class', 'stream',
    ];
}
