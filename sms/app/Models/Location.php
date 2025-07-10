<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'type', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function districts()
    {
        return $this->hasMany(Location::class, 'parent_id')->where('type', 'district');
    }

    public function scopeStates($query)
    {
        return $query->where('type', 'state');
    }

    public function scopeDistricts($query)
    {
        return $query->where('type', 'district');
    }
}
