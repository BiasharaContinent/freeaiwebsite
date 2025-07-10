@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Confirm AI Extracted Data') }}</div>

                <div class="card-body">
                    <p>Our AI has processed your resume. Review the extracted information below. If it looks good, you can use it to start creating your new resume.</p>
                    <p class="text-muted"><small>Note: This is based on a placeholder AI service. The actual quality of extraction will depend on the real AI model used.</small></p>

                    <div class="extracted-data-summary mt-4 mb-4 p-3" style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: .25rem;">
                        <h4>Summary of Extracted Data:</h4>
                        <ul>
                            @if(isset($structuredData['personal_info']['full_name']))
                                <li><strong>Name:</strong> {{ $structuredData['personal_info']['full_name'] }}</li>
                            @endif
                            @if(isset($structuredData['personal_info']['email']))
                                <li><strong>Email:</strong> {{ $structuredData['personal_info']['email'] }}</li>
                            @endif
                            @if(isset($structuredData['work_experiences']) && count($structuredData['work_experiences']) > 0)
                                <li><strong>Work Experiences Found:</strong> {{ count($structuredData['work_experiences']) }}</li>
                                @foreach($structuredData['work_experiences'] as $exp)
                                    <ul style="margin-left: 20px;">
                                        <li>{{ $exp['job_title'] ?? 'N/A' }} at {{ $exp['company'] ?? 'N/A' }}</li>
                                    </ul>
                                @endforeach
                            @endif
                            @if(isset($structuredData['education_entries']) && count($structuredData['education_entries']) > 0)
                                <li><strong>Education Entries Found:</strong> {{ count($structuredData['education_entries']) }}</li>
                            @endif
                             @if(isset($structuredData['skills_list']) && count($structuredData['skills_list']) > 0)
                                <li><strong>Skills Found:</strong> {{ count($structuredData['skills_list']) }}</li>
                            @endif
                        </ul>
                        <button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="collapse" data-target="#collapseRawData" aria-expanded="false" aria-controls="collapseRawData">
                            Show/Hide Full Extracted JSON
                        </button>
                        <div class="collapse mt-2" id="collapseRawData">
                            <pre style="max-height: 300px; overflow-y: auto; background-color: #fff; padding:10px; border: 1px solid #ccc;">{{ json_encode($structuredData, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>

                    <div class="original-text-display mt-4 mb-4">
                         <button class="btn btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#collapseOriginalText" aria-expanded="false" aria-controls="collapseOriginalText">
                            Show/Hide Original Extracted PDF Text
                        </button>
                        <div class="collapse mt-2" id="collapseOriginalText">
                            <pre style="max-height: 300px; overflow-y: auto; background-color: #fff; padding:10px; border: 1px solid #ccc; white-space: pre-wrap;">{{ $originalText ?? 'No original text found in session.' }}</pre>
                        </div>
                    </div>


                    <form action="{{ route('resumes.create') }}" method="GET">
                        {{-- We'll pass a flag or the data itself via query parameters or re-session for create form --}}
                        {{-- For simplicity, the 'create' method in ResumeController will check session for 'ai_prefill_data' --}}
                        <input type="hidden" name="use_ai_data" value="1">
                        <button type="submit" class="btn btn-success btn-lg">
                            {{ __('Yes, Use This Data to Start My Resume') }}
                        </button>
                        <a href="{{ route('ai.uploadForm') }}" class="btn btn-outline-secondary btn-lg ml-2">{{ __('Upload Different PDF') }}</a>
                        <a href="{{ route('resumes.create') }}" class="btn btn-outline-info btn-lg ml-2">{{ __('Start Manually Instead') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
