<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'full_name',
        'email',
        'phone',
        'location',
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'profile_photo_path',
    ];

    /**
     * Get the resume that this personal info belongs to.
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
