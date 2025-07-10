<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'preview_image_path',
        'view_name',
        'font_specs',
        'color_specs',
        'layout_specs_json',
        'is_active',
    ];

    protected $casts = [
        'font_specs' => 'array',
        'color_specs' => 'array',
        'layout_specs_json' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the resumes that use this template.
     */
    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    /**
     * Scope a query to only include active templates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
