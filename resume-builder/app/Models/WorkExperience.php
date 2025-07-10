<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'job_title',
        'company',
        'city_state',
        'start_date',
        'end_date',
        'is_current',
        'responsibilities',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        // 'responsibilities' => 'array', // Consider casting to array if storing as JSON
    ];

    /**
     * Get the resume that this work experience belongs to.
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
