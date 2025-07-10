<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'award_name',
        'awarding_body',
        'date_awarded',
        'summary',
    ];

    protected $casts = [
        'date_awarded' => 'date',
    ];

    /**
     * Get the resume that this award belongs to.
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
