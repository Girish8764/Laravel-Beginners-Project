<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $table = 'students';
    protected $fillable = [
        'dice_code', 'rollno', 'b_rollno', 'admission_date', 'sr_no',
        'admission_class', 'stream', 'section', 'medium',
        'subject1', 'subject2', 'subject3', 'subject4', 'subject5',
        'subject6', 'subject7', 'subject8', 'subject9',
        'third', 'student_name', 'father_name', 'mother_name',
        'grand_father', 'g_age', 'dob', 'gender', 'caste', 'category',
        'religion', 'aadhar', 'pan_no', 'f_aadhar', 'f_dob', 'f_place',
        'jan_aadhar', 'mobile', 'gmail', 'address', 'district', 'tehsil',
        'gram', 'occupation', 'income', 'rte', 'class1', 'year1', 'old_rollno1',
        'old_result1', 'old_board1', 'class2', 'year2', 'old_rollno2',
        'old_result2', 'old_board2', 'class3', 'year3', 'old_rollno3',
        'old_result3', 'old_board3', 'father_mother_aadhar', 'labour_card',
        'labour_no', 'labour_date', 'validity_date', 'officer_issuing',
        'tc', 'img', 'card', 'status', 'date', 'session', 'add_fee',
        'tution_fee', 'con_fee', 'total_fee', 'email', 'password', 'date',

    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

  public function feeDeposits()
    {
        return $this->hasMany(FeeDeposit::class);
    }

    public function isRTE()
    {
        return strtoupper($this->category) === 'RTE';
    }

    public function getTotalFeePaidAttribute()
    {
        return $this->feeDeposits->sum('amount_paid');
    }

    public function getApplicableFee()
    {
        $classCode = \DB::table('classes')
                      ->where('name', $this->admission_class)
                      ->value('code');

        return Fee::where('dice_code', $this->dice_code)
                 ->where('class_code', $classCode)
                 ->where(function($query) {
                     $query->where('stream', $this->stream)
                           ->orWhereNull('stream')
                           ->orWhere('stream', '');
                 })
                 ->orderByRaw("FIELD(stream, ?, '', NULL)", [$this->stream])
                 ->first();
    }

    public function calculateTotalFee()
    {
        $fee = $this->getApplicableFee();
        
        if (!$fee) {
            return 0;
        }

        return $fee->calculateTotalFee($this->isRTE());
    }

    public function getPendingFeeAmount()
    {
        $totalFee = $this->calculateTotalFee();
        $totalPaid = $this->getTotalFeePaidAttribute();
        
        return max(0, $totalFee - $totalPaid);
    }

    
}
