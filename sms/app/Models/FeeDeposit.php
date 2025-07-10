<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeDeposit extends Model
{
    protected $fillable = [
        'student_id', 'amount_paid', 'late_fee', 'concession_amount', 'paid_on', 'payment_mode', 'remarks'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}