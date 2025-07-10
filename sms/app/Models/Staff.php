<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    protected $table = 'teachers';
    use Notifiable;
    protected $fillable = [
        'dice_code', 'name', 'm_name', 'f_name', 'dob', 'religion', 'category',
        'email', 'mobile', 'aadhar', 'gender', 'joining', 'password',
        'subject', 'accdmic', 'pro', 'address', 'img', 'status', 'card', 'date',
    ];
}
