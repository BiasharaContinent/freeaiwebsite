<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'title',
        'content',
    ];

    protected $casts = [
        // 'content' => 'array', // Consider casting to array if storing as JSON
    ];

    /**
     * Get the resume that this custom section belongs to.
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
