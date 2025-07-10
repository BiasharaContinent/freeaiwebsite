<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'language_name',
        'proficiency',
    ];

    /**
     * Get the resume that this language entry belongs to.
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
