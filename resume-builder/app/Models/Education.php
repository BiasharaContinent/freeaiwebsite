<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'degree',
        'institution',
        'major',
        'city_state',
        'graduation_start_date',
        'graduation_end_date',
        'details',
    ];

    protected $casts = [
        'graduation_start_date' => 'date',
        'graduation_end_date' => 'date',
        // 'details' => 'array', // Consider casting to array if storing as JSON
    ];

    /**
     * Get the resume that this education entry belongs to.
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
