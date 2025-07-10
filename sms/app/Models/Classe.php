<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = 'classes'; // your table name is `classes`
    public $timestamps = false;   // if your table doesn't use timestamps
    protected $fillable = ['id', 'code', 'name'];
}
