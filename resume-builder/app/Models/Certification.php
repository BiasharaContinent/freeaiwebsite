<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'name',
        'issuing_organization',
        'date_issued',
        'credential_id',
        'credential_url',
        'expiration_date',
    ];

    protected $casts = [
        'date_issued' => 'date',
        'expiration_date' => 'date',
    ];

    /**
     * Get the resume that this certification belongs to.
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
