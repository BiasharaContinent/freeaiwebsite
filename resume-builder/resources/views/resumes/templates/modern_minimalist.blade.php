<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume->personalInfo->full_name ?? 'Resume' }} - {{ $resume->title }}</title>
    <style>
        /* Using Google Fonts (ensure they are available or use web safe fonts) */
        @import url('https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $resume->template->font_specs['heading'] ?? 'Montserrat') }}:wght@400;700&family={{ str_replace(' ', '+', $resume->template->font_specs['body'] ?? 'Roboto') }}:wght@400;700&display=swap');

        body {
            font-family: '{{ $resume->template->font_specs['body'] ?? 'Roboto' }}', sans-serif;
            line-height: 1.6;
            color: {{ $resume->template->color_specs['primary'] ?? '#2c3e50' }};
            background-color: {{ $resume->template->color_specs['background'] ?? '#FFFFFF' }};
            margin: 0;
            padding: 0;
            font-size: 11pt; /* Base font size for PDF */
        }
        .page-container {
            width: 210mm; /* A4 width */
            min-height: 297mm; /* A4 height */
            margin: auto; /* Center page on screen, for PDF it's less relevant */
            padding: 15mm; /* Margins */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid {{ $resume->template->color_specs['accent'] ?? '#3498db' }};
        }
        .header h1 {
            font-family: '{{ $resume->template->font_specs['heading'] ?? 'Montserrat' }}', sans-serif;
            font-size: 28pt;
            color: {{ $resume->template->color_specs['accent'] ?? '#3498db' }};
            margin: 0 0 5px 0;
            font-weight: 700;
        }
        .header .contact-info {
            font-size: 9pt;
            color: {{ $resume->template->color_specs['primary'] ?? '#2c3e50' }};
        }
        .contact-info a {
            color: {{ $resume->template->color_specs['primary'] ?? '#2c3e50' }};
            text-decoration: none;
        }
        .contact-info span { margin: 0 5px; }

        .section {
            margin-bottom: 15px;
        }
        .section-title {
            font-family: '{{ $resume->template->font_specs['heading'] ?? 'Montserrat' }}', sans-serif;
            font-size: 14pt;
            color: {{ $resume->template->color_specs['accent'] ?? '#3498db' }};
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid {{ $resume->template->color_specs['accent'] ?? '#3498db' }};
            font-weight: 700;
        }
        .entry {
            margin-bottom: 10px;
        }
        .entry h3 {
            font-family: '{{ $resume->template->font_specs['heading'] ?? 'Montserrat' }}', sans-serif;
            font-size: 11pt;
            margin: 0 0 2px 0;
            font-weight: 700;
        }
        .entry .company, .entry .institution {
            font-size: 10pt;
            font-style: italic;
            color: {{ ($resume->template->color_specs['primary'] ?? '#2c3e50') . 'cc' }}; /* slightly lighter */
        }
        .entry .date-range {
            float: right;
            font-size: 9pt;
            font-style: italic;
            color: {{ ($resume->template->color_specs['primary'] ?? '#2c3e50') . 'aa' }}; /* even lighter */
        }
        .clear { clear: both; }
        .entry ul {
            list-style-type: disc;
            margin: 5px 0 5px 20px;
            padding: 0;
            font-size: 10pt;
        }
        .entry ul li {
            margin-bottom: 3px;
        }
        .skills-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex; /* For dompdf, flex might be tricky, test thoroughly */
            flex-wrap: wrap;
        }
        .skills-list li {
            background-color: {{ ($resume->template->color_specs['accent'] ?? '#3498db').'22' }}; /* Light accent bg */
            color: {{ $resume->template->color_specs['accent'] ?? '#3498db' }};
            padding: 3px 8px;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 4px;
            font-size: 9pt;
        }
        .skill-type-heading {
            font-family: '{{ $resume->template->font_specs['heading'] ?? 'Montserrat' }}', sans-serif;
            font-size: 10pt;
            font-weight: bold;
            margin-top: 8px;
            margin-bottom: 4px;
            display: block;
        }

        /* For PDF generation, ensure images are handled well if you add profile photo */
        .profile-photo {
            /* Styles for profile photo if you add it to this template */
        }

        @media print {
            body { margin: 0; background-color: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .page-container { margin:0; width: 100%; min-height: 0; padding: 10mm; box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="page-container">
        @if($resume->personalInfo)
            <div class="header">
                <h1>{{ $resume->personalInfo->full_name }}</h1>
                <div class="contact-info">
                    @if($resume->personalInfo->email) <a href="mailto:{{ $resume->personalInfo->email }}">{{ $resume->personalInfo->email }}</a> @endif
                    @if($resume->personalInfo->phone) <span>&bull;</span> {{ $resume->personalInfo->phone }} @endif
                    @if($resume->personalInfo->location) <span>&bull;</span> {{ $resume->personalInfo->location }} @endif
                    <br>
                    @if($resume->personalInfo->linkedin_url) <a href="{{ $resume->personalInfo->linkedin_url }}">LinkedIn</a> @endif
                    @if($resume->personalInfo->github_url) @if($resume->personalInfo->linkedin_url)<span>&bull;</span>@endif <a href="{{ $resume->personalInfo->github_url }}">GitHub</a> @endif
                    @if($resume->personalInfo->portfolio_url) @if($resume->personalInfo->linkedin_url || $resume->personalInfo->github_url)<span>&bull;</span>@endif <a href="{{ $resume->personalInfo->portfolio_url }}">Portfolio</a> @endif
                </div>
            </div>
        @endif

        @if($resume->professionalSummary && !empty($resume->professionalSummary->summary_text))
            <div class="section summary-section">
                <div class="section-title">Professional Summary</div>
                <p>{{ $resume->professionalSummary->summary_text }}</p>
            </div>
        @endif

        @if($resume->workExperiences && $resume->workExperiences->count() > 0)
            <div class="section experience-section">
                <div class="section-title">Work Experience</div>
                @foreach($resume->workExperiences->sortByDesc('start_date') as $exp)
                    <div class="entry">
                        <span class="date-range">{{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'N/A') }}</span>
                        <h3>{{ $exp->job_title }}</h3>
                        <div class="company">{{ $exp->company }} @if($exp->city_state) | {{ $exp->city_state }} @endif</div>
                        <div class="clear"></div>
                        @if($exp->responsibilities)
                            <ul>
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
                <div class="section-title">Education</div>
                @foreach($resume->educations->sortByDesc('graduation_end_date') as $edu)
                    <div class="entry">
                        <span class="date-range">{{ $edu->graduation_start_date ? \Carbon\Carbon::parse($edu->graduation_start_date)->format('M Y').' - ' : '' }}{{ $edu->graduation_end_date ? \Carbon\Carbon::parse($edu->graduation_end_date)->format('M Y') : 'N/A' }}</span>
                        <h3>{{ $edu->degree }} {{ $edu->major ? '- '.$edu->major : '' }}</h3>
                        <div class="institution">{{ $edu->institution }} @if($edu->city_state) | {{ $edu->city_state }} @endif</div>
                        <div class="clear"></div>
                        @if($edu->details)
                            <ul>
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
                <div class="section-title">Skills</div>
                 @php $groupedSkills = $resume->skills->groupBy('type'); @endphp
                 @if(isset($groupedSkills['technical']) && $groupedSkills['technical']->count() > 0)
                    <span class="skill-type-heading">Technical</span>
                    <ul class="skills-list">
                        @foreach($groupedSkills['technical'] as $skill) <li>{{ $skill->skill_name }}</li> @endforeach
                    </ul>
                 @endif
                 @if(isset($groupedSkills['hard']) && $groupedSkills['hard']->count() > 0)
                    <span class="skill-type-heading">Hard Skills</span>
                    <ul class="skills-list">
                        @foreach($groupedSkills['hard'] as $skill) <li>{{ $skill->skill_name }}</li> @endforeach
                    </ul>
                 @endif
                 @if(isset($groupedSkills['soft']) && $groupedSkills['soft']->count() > 0)
                    <span class="skill-type-heading">Soft Skills</span>
                    <ul class="skills-list">
                        @foreach($groupedSkills['soft'] as $skill) <li>{{ $skill->skill_name }}</li> @endforeach
                    </ul>
                 @endif
                 @if(isset($groupedSkills['other']) && $groupedSkills['other']->count() > 0)
                    <span class="skill-type-heading">Other</span>
                    <ul class="skills-list">
                        @foreach($groupedSkills['other'] as $skill) <li>{{ $skill->skill_name }}</li> @endforeach
                    </ul>
                 @endif
            </div>
        @endif

        @if($resume->certifications && $resume->certifications->count() > 0)
            <div class="section certifications-section">
                <div class="section-title">Certifications</div>
                @foreach($resume->certifications as $cert)
                    <div class="entry">
                        <h3>{{ $cert->name }}</h3>
                        <div class="institution">{{ $cert->issuing_organization }} @if($cert->date_issued) ({{ \Carbon\Carbon::parse($cert->date_issued)->format('M Y') }}) @endif</div>
                        @if($cert->credential_url) <div style="font-size:9pt;"><a href="{{$cert->credential_url}}">Verify</a></div> @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if($resume->languages && $resume->languages->count() > 0)
            <div class="section languages-section">
                <div class="section-title">Languages</div>
                 <ul class="skills-list">
                    @foreach($resume->languages as $lang)
                        <li>{{ $lang->language_name }} ({{ $lang->proficiency }})</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($resume->awards && $resume->awards->count() > 0)
            <div class="section awards-section">
                <div class="section-title">Awards & Honors</div>
                @foreach($resume->awards as $award)
                     <div class="entry">
                        <h3>{{ $award->award_name }}</h3>
                        <div class="institution">
                            @if($award->awarding_body) {{ $award->awarding_body }} @endif
                            @if($award->date_awarded) ({{ \Carbon\Carbon::parse($award->date_awarded)->format('M Y') }}) @endif
                        </div>
                        @if($award->summary) <p style="font-size:10pt; margin-top:3px;">{{ $award->summary }}</p> @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if($resume->customSections && $resume->customSections->count() > 0)
            @foreach($resume->customSections as $custom)
                <div class="section custom-section">
                    <div class="section-title">{{ $custom->title }}</div>
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
