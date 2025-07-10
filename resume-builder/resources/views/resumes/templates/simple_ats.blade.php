<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume - {{ $resume->personalInfo->full_name ?? 'User' }} (Simple ATS)</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.3; }
        h1, h2, h3 { margin-bottom: 0.2em; }
        h1 { font-size: 20px; text-align: center; }
        h2 { font-size: 16px; border-bottom: 1px solid #000; margin-top: 10px;}
        h3 { font-size: 14px; }
        ul { padding-left: 20px; margin-top: 5px;}
        .section { margin-bottom: 10px; }
        .contact p { margin: 1px 0; font-size: 12px; text-align: center;}
    </style>
</head>
<body>
    <h1>{{ $resume->personalInfo->full_name ?? 'N/A' }}</h1>
    <div class="contact">
        <p>{{ $resume->personalInfo->email ?? 'N/A' }} | {{ $resume->personalInfo->phone ?? 'N/A' }} | {{ $resume->personalInfo->location ?? 'N/A' }}</p>
        @if($resume->personalInfo->linkedin_url) <p>LinkedIn: {{ $resume->personalInfo->linkedin_url }}</p> @endif
    </div>

    @if($resume->professionalSummary && $resume->professionalSummary->summary_text)
    <div class="section">
        <h2>PROFESSIONAL SUMMARY</h2>
        <p>{{ $resume->professionalSummary->summary_text }}</p>
    </div>
    @endif

    @if($resume->workExperiences && $resume->workExperiences->count() > 0)
    <div class="section">
        <h2>WORK EXPERIENCE</h2>
        @foreach($resume->workExperiences->sortByDesc('start_date') as $exp)
            <h3>{{ $exp->job_title }}</h3>
            <p>{{ $exp->company }} | {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'N/A') }}</p>
            @if($exp->responsibilities)
            <ul>@foreach(explode("\n", trim($exp->responsibilities)) as $r) @if(trim($r))<li>{{ ltrim(trim($r), '- ') }}</li>@endif @endforeach</ul>
            @endif
        @endforeach
    </div>
    @endif

    @if($resume->educations && $resume->educations->count() > 0)
    <div class="section">
        <h2>EDUCATION</h2>
        @foreach($resume->educations->sortByDesc('graduation_end_date') as $edu)
            <h3>{{ $edu->degree }} {{ $edu->major ? '- '.$edu->major : '' }}</h3>
            <p>{{ $edu->institution }} | {{ $edu->graduation_end_date ? \Carbon\Carbon::parse($edu->graduation_end_date)->format('M Y') : 'N/A' }}</p>
            @if($edu->details)
            <ul>@foreach(explode("\n", trim($edu->details)) as $d) @if(trim($d))<li>{{ ltrim(trim($d), '- ') }}</li>@endif @endforeach</ul>
            @endif
        @endforeach
    </div>
    @endif

    @if($resume->skills && $resume->skills->count() > 0)
    <div class="section">
        <h2>SKILLS</h2>
        <p>
        @foreach($resume->skills as $index => $skill)
            {{ $skill->skill_name }}{{ !$loop->last ? ', ' : '' }}
        @endforeach
        </p>
    </div>
    @endif

    {{-- Add other sections (Certifications, Languages, Awards, Custom) similarly if needed for this basic template --}}

</body>
</html>
