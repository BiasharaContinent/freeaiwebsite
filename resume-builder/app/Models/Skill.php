<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_name',
        'type',
    ];

    /**
     * The resumes that have this skill.
     */
    public function resumes()
    {
        return $this->belongsToMany(Resume::class, 'resume_skill')->withTimestamps();
    }
}
