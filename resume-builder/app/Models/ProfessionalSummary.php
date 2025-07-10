<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'summary_text',
    ];

    /**
     * Get the resume that this summary belongs to.
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
