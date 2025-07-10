<?php

// File: app/Models/IdCardTemplate.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IdCardTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'orientation',
        'type',
        'template_data',
        'css_styles',
        'width',
        'height',
        'is_active'
    ];

    protected $casts = [
        'template_data' => 'array',
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    // Scope for active templates
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for filtering by type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessor for formatted dimensions
    public function getDimensionsAttribute()
    {
        return $this->width . 'x' . $this->height;
    }

    // Accessor for template data as JSON string
    public function getTemplateDataJsonAttribute()
    {
        return json_encode($this->template_data);
    }
}