<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'stream', 'class', 'dice_code','is_third_language'];
    public function globalSubject()
{
    return $this->belongsTo(GlobalSubject::class, 'global_subject_id');
}

}
