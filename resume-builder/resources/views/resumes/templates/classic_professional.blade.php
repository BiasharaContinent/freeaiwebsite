<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume->personalInfo->full_name ?? 'Resume' }} - {{ $resume->title }}</title>
    <style>
        body {
            font-family: {{ $resume->template->font_specs['body'] ?? 'Times New Roman, serif' }};
            line-height: 1.4;
            color: {{ $resume->template->color_specs['primary'] ?? '#333333' }};
            margin: 0;
            padding: 0;
            background-color: {{ $resume->template->color_specs['background'] ?? '#FFFFFF' }};
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc; /* Simple border for ATS */
        }
        h1, h2, h3, h4 {
            font-family: {{ $resume->template->font_specs['heading'] ?? 'Georgia, serif' }};
            color: {{ $resume->template->color_specs['accent'] ?? '#000000' }};
            margin-top: 0;
            margin-bottom: 0.5em;
        }
        h1 { font-size: 24px; text-align: center; }
        h2 { font-size: 18px; border-bottom: 1px solid {{ $resume->template->color_specs['accent'] ?? '#000000' }}; padding-bottom: 0.2em; margin-top: 1em;}
        h3 { font-size: 16px; }
        h4 { font-size: 14px; font-style: italic;}
        p { margin-bottom: 0.5em; }
        ul { padding-left: 20px; margin-bottom: 1em; }
        li { margin-bottom: 0.2em; }
        .header-contact { text-align: center; margin-bottom: 1em; }
        .header-contact p { margin: 2px 0; font-size: 12px; }
        .section { margin-bottom: 1em; }
        .job-title, .degree-title { font-weight: bold; }
        .company, .institution { font-style: italic; }
        .date-range { float: right; font-size: 0.9em; }
        .responsibilities, .details { margin-top: 0.3em; }
        .clear { clear: both; }

        /* Basic two-column for skills - can be complex for ATS */
        .skills-list {
            list-style: none;
            padding: 0;
            margin: 0;
            /* display: flex;
            flex-wrap: wrap; */ /* Flexbox might be too much for basic ATS */
        }
        .skills-list li {
            /* flex-basis: 50%; */ /* For two columns */
            padding-right: 10px; /* Spacing between skill columns */
        }
        .skill-type {
            font-weight: bold;
            margin-top: 0.5em;
            display: block;
        }

        @media print {
            body { margin: 0; border: none; }
            .container { border: none; box-shadow: none; margin:0; max-width: 100%;}
        }
    </style>
</head>
<body>
    <div class="container">
        @if($resume->personalInfo)
            <h1>{{ $resume->personalInfo->full_name }}</h1>
            <div class="header-contact">
                @if($resume->personalInfo->email) <p>{{ $resume->personalInfo->email }}</p> @endif
                @if($resume->personalInfo->phone) <p>{{ $resume->personalInfo->phone }}</p> @endif
                @if($resume->personalInfo->location) <p>{{ $resume->personalInfo->location }}</p> @endif
                @if($resume->personalInfo->linkedin_url) <p>LinkedIn: {{ $resume->personalInfo->linkedin_url }}</p> @endif
                @if($resume->personalInfo->github_url) <p>GitHub: {{ $resume->personalInfo->github_url }}</p> @endif
                @if($resume->personalInfo->portfolio_url) <p>Portfolio: {{ $resume->personalInfo->portfolio_url }}</p> @endif
            </div>
        @endif

        @if($resume->professionalSummary && !empty($resume->professionalSummary->summary_text))
            <div class="section summary-section">
                <h2>Summary</h2>
                <p>{{ $resume->professionalSummary->summary_text }}</p>
            </div>
        @endif

        @if($resume->workExperiences && $resume->workExperiences->count() > 0)
            <div class="section experience-section">
                <h2>Work Experience</h2>
                @foreach($resume->workExperiences->sortByDesc('start_date') as $exp)
                    <div class="entry">
                        <h3><span class="job-title">{{ $exp->job_title }}</span> at <span class="company">{{ $exp->company }}</span></h3>
                        <p class="date-range">{{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'N/A') }}</p>
                        <p>{{ $exp->city_state }}</p>
                        <div class="clear"></div>
                        @if($exp->responsibilities)
                            <ul class="responsibilities">
                                @foreach(explode("\n", trim($exp->responsibilities)) as $responsibility)
                                    @if(trim($responsibility))
                                        <li>{{ ltrim(trim($responsibility), '- ') }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if($resume->educations && $resume->educations->count() > 0)
            <div class="section education-section">
                <h2>Education</h2>
                @foreach($resume->educations->sortByDesc('graduation_end_date') as $edu)
                    <div class="entry">
                        <h3><span class="degree-title">{{ $edu->degree }}</span> - {{ $edu->major ?? '' }}</h3>
                        <p class="date-range">{{ $edu->graduation_start_date ? \Carbon\Carbon::parse($edu->graduation_start_date)->format('M Y').' - ' : '' }}{{ $edu->graduation_end_date ? \Carbon\Carbon::parse($edu->graduation_end_date)->format('M Y') : 'N/A' }}</p>
                        <p><span class="institution">{{ $edu->institution }}</span>, {{ $edu->city_state }}</p>
                        <div class="clear"></div>
                        @if($edu->details)
                            <ul class="details">
                                @foreach(explode("\n", trim($edu->details)) as $detail)
                                     @if(trim($detail))
                                        <li>{{ ltrim(trim($detail), '- ') }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if($resume->skills && $resume->skills->count() > 0)
            <div class="section skills-section">
                <h2>Skills</h2>
                <ul class="skills-list">
                    @foreach($resume->skills->groupBy('type') as $type => $skillsOfType)
                        @if($type && $type !== 'other') <span class="skill-type">{{ ucfirst($type) }} Skills:</span> @endif
                        @foreach($skillsOfType as $skill)
                            <li>{{ $skill->skill_name }}</li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
        @endif

        @if($resume->certifications && $resume->certifications->count() > 0)
            <div class="section certifications-section">
                <h2>Certifications</h2>
                @foreach($resume->certifications as $cert)
                    <div class="entry">
                        <p><span class="job-title">{{ $cert->name }}</span> - {{ $cert->issuing_organization }}
                        @if($cert->date_issued) ({{ \Carbon\Carbon::parse($cert->date_issued)->format('M Y') }}) @endif
                        </p>
                        @if($cert->credential_url) <p><small>Verify at: {{ $cert->credential_url }}</small></p> @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if($resume->languages && $resume->languages->count() > 0)
            <div class="section languages-section">
                <h2>Languages</h2>
                 <ul class="skills-list"> {{-- Re-use skills list style for simplicity --}}
                    @foreach($resume->languages as $lang)
                        <li>{{ $lang->language_name }} ({{ $lang->proficiency }})</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($resume->awards && $resume->awards->count() > 0)
            <div class="section awards-section">
                <h2>Awards and Honors</h2>
                @foreach($resume->awards as $award)
                     <div class="entry">
                        <p><span class="job-title">{{ $award->award_name }}</span>
                        @if($award->awarding_body) - {{ $award->awarding_body }} @endif
                        @if($award->date_awarded) ({{ \Carbon\Carbon::parse($award->date_awarded)->format('M Y') }}) @endif
                        </p>
                        @if($award->summary) <p><small>{{ $award->summary }}</small></p> @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if($resume->customSections && $resume->customSections->count() > 0)
            @foreach($resume->customSections as $custom)
                <div class="section custom-section">
                    <h2>{{ $custom->title }}</h2>
                    {{-- Assuming content might be multi-line or simple paragraph --}}
                    @php $lines = explode("\n", trim($custom->content)); @endphp
                    @if(count($lines) > 1 || str_starts_with($lines[0] ?? '', '- '))
                        <ul>
                        @foreach($lines as $line)
                            @if(trim($line))
                                <li>{{ ltrim(trim($line), '- ') }}</li>
                            @endif
                        @endforeach
                        </ul>
                    @else
                        <p>{{ $custom->content }}</p>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
