<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume - {{ $resume->personalInfo->full_name ?? 'User' }} (Creative Styled)</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Raleway:wght@400;700&display=swap');
        body { font-family: 'Lato', sans-serif; background-color: #f9f9f9; color: #333; padding: 20px; }
        .container { max-width: 900px; margin: auto; background-color: #fff; padding: 30px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        h1, h2, h3 { font-family: 'Raleway', sans-serif; color: #e74c3c; }
        h1 { text-align: center; font-size: 32px; }
        h2 { font-size: 22px; border-bottom: 2px solid #e74c3c; padding-bottom: 5px; margin-top: 25px; }
        h3 { font-size: 18px; color: #555;}
        .contact-info { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 20px; }
        .date-right { float: right; color: #777; font-style: italic; }
        .clear { clear: both; }
        ul { list-style-type: none; padding-left: 0;}
        ul li { background: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2210%22%20height%3D%2210%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Ccircle%20cx%3D%225%22%20cy%3D%225%22%20r%3D%223%22%20fill%3D%22%23e74c3c%22/%3E%3C/svg%3E') no-repeat left 5px; padding-left: 15px; margin-bottom: 5px;}

    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $resume->personalInfo->full_name ?? 'N/A' }}</h1>
        <div class="contact-info">
            {{ $resume->personalInfo->email ?? 'N/A' }} | {{ $resume->personalInfo->phone ?? 'N/A' }} | {{ $resume->personalInfo->location ?? 'N/A' }}
            @if($resume->personalInfo->linkedin_url) | <a href="{{ $resume->personalInfo->linkedin_url }}">LinkedIn</a>@endif
        </div>

        @if($resume->professionalSummary && $resume->professionalSummary->summary_text)
        <div class="section">
            <h2>SUMMARY</h2>
            <p>{{ $resume->professionalSummary->summary_text }}</p>
        </div>
        @endif

        @if($resume->workExperiences && $resume->workExperiences->count() > 0)
        <div class="section">
            <h2>EXPERIENCE</h2>
            @foreach($resume->workExperiences->sortByDesc('start_date') as $exp)
                <div>
                    <span class="date-right">{{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'N/A') }}</span>
                    <h3>{{ $exp->job_title }}</h3>
                    <p><em>{{ $exp->company }}</em></p>
                    <div class="clear"></div>
                    @if($exp->responsibilities)
                    <ul>@foreach(explode("\n", trim($exp->responsibilities)) as $r) @if(trim($r))<li>{{ ltrim(trim($r), '- ') }}</li>@endif @endforeach</ul>
                    @endif
                </div>
            @endforeach
        </div>
        @endif

        @if($resume->educations && $resume->educations->count() > 0)
        <div class="section">
            <h2>EDUCATION</h2>
            @foreach($resume->educations->sortByDesc('graduation_end_date') as $edu)
                <div>
                    <span class="date-right">{{ $edu->graduation_end_date ? \Carbon\Carbon::parse($edu->graduation_end_date)->format('M Y') : 'N/A' }}</span>
                    <h3>{{ $edu->degree }} {{ $edu->major ? '- '.$edu->major : '' }}</h3>
                    <p><em>{{ $edu->institution }}</em></p>
                    <div class="clear"></div>
                    @if($edu->details)
                    <ul>@foreach(explode("\n", trim($edu->details)) as $d) @if(trim($d))<li>{{ ltrim(trim($d), '- ') }}</li>@endif @endforeach</ul>
                    @endif
                </div>
            @endforeach
        </div>
        @endif

        @if($resume->skills && $resume->skills->count() > 0)
        <div class="section">
            <h2>SKILLS</h2>
            <p>
            @foreach($resume->skills as $index => $skill)
                {{ $skill->skill_name }}{{ !$loop->last ? ' • ' : '' }}
            @endforeach
            </p>
        </div>
        @endif
        {{-- Add other sections (Certifications, Languages, Awards, Custom) similarly if needed --}}
    </div>
</body>
</html>
