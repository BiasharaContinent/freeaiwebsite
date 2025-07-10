<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'title',
        'format_type',
        'is_draft',
        'public_link_slug',
    ];

    /**
     * Get the user that owns the resume.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the template used for this resume.
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Get the personal information associated with the resume.
     */
    public function personalInfo()
    {
        return $this->hasOne(PersonalInfo::class);
    }

    /**
     * Get the professional summary associated with the resume.
     */
    public function professionalSummary()
    {
        return $this->hasOne(ProfessionalSummary::class);
    }

    /**
     * Get the work experiences for the resume.
     */
    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    /**
     * Get the education entries for the resume.
     */
    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    /**
     * The skills that belong to the resume.
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'resume_skill')->withTimestamps();
    }

    /**
     * Get the certifications for the resume.
     */
    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Get the languages for the resume.
     */
    public function languages()
    {
        return $this->hasMany(Language::class);
    }

    /**
     * Get the awards for the resume.
     */
    public function awards()
    {
        return $this->hasMany(Award::class);
    }

    /**
     * Get the custom sections for the resume.
     */
    public function customSections()
    {
        return $this->hasMany(CustomSection::class);
    }
}
