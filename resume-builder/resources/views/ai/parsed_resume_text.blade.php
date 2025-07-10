@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Extracted Resume Text') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <p>The following text was extracted from your PDF. In the next step, this text would be sent to an AI for analysis and structuring.</p>

                    {{--
                    <div class="mb-3">
                        <strong>PDF Title (from metadata):</strong> {{ $title ?? 'N/A' }}
                    </div>
                    --}}

                    <div class="extracted-text-area p-3" style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: .25rem; white-space: pre-wrap; max-height: 500px; overflow-y: auto;">
                        {{ $extractedText }}
                    </div>

                    <div class="mt-4">
                        {{-- This button would eventually lead to the AI processing step --}}
                        {{-- <a href="{{ route('ai.processResume') }}" class="btn btn-primary">Proceed to AI Analysis (Next Step)</a> --}}
                        <a href="{{ route('resumes.create') }}?prefill_text={{ urlencode($extractedText) }}" class="btn btn-success">Use this text to Start a New Resume</a>
                        <a href="{{ route('ai.uploadForm') }}" class="btn btn-secondary ml-2">Upload a different PDF</a>
                    </div>
                    <p class="mt-3 text-muted"><small>Note: The "Use this text" button is a placeholder. Actual pre-filling will involve sending this text to the AI to structure it into form fields.</small></p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
