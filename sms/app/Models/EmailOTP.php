<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailOTP extends Model
{

    protected $table = 'email_otps'; 
    protected $fillable = [
        'email', 'otp', 'role', 'dice_code', 'expires_at',
    ];

    public $timestamps = true;

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
