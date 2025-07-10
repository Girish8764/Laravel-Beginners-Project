<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'dice_code', 'class_code', 'stream',
        'admission_fee', 'tuition_fee', 'rte_fee', 'late_fee', 'concession_amount', 'total_fee'
    ];

    public function calculateTotalFee($isRTE = false)
    {
        if ($isRTE) {
            // For RTE students, only RTE fee applies
            return $this->rte_fee + $this->late_fee - $this->concession_amount;
        } else {
            // For regular students, admission + tuition + late fee - concession
            return $this->admission_fee + $this->tuition_fee + $this->late_fee - $this->concession_amount;
        }
    }
}