<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'dice_code',
        'school_name',
        'email',
        'mobile',
        'password',
        'is_active',
        'Sch_code',
        'Psp_code',
        'phone',
        'medium',
        'School_type',
        'Aff_year',
        'Aff_no',
        'standrad',
        'sec_year',
        'sr_sec_year',
        'address',
        'village',
        'tehsil',
        'district',
        'state',
        'image',
    ];

    protected $hidden = ['password'];

    protected $casts = ['is_active' => 'boolean'];

    public function teachers()
    {
        return $this->hasMany(Staff::class, 'dice_code', 'dice_code');
    }

}
