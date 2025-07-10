<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'duration',
        'features',
        'is_featured'
    ];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2'
    ];
}