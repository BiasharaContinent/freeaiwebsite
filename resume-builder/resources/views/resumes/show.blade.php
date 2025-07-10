@extends('layouts.app') {{-- Or a different layout for previews if needed --}}

@section('content')
<div class="container-fluid"> {{-- Use fluid for wider preview potentially --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Preview: {{ $resume->title }}</h2>
                <div>
                    <a href="{{ route('resumes.edit', $resume->id) }}" class="btn btn-info">{{ __('Edit Resume') }}</a>
                    <a href="{{ route('resumes.downloadPdf', $resume->id) }}" class="btn btn-primary">{{ __('Download PDF') }}</a>
                </div>
            </div>
            <p>
                <strong>Selected Template:</strong> {{ $resume->template->name ?? 'None (Default Rendering)' }} <br>
                <strong>Format Type:</strong> {{ ucfirst($resume->format_type) }}
            </p>
        </div>
    </div>

    <div class="resume-preview-area" style="border: 1px solid #ddd; background-color: #fdfdfd; padding: 20px;">
        @if ($resume->template && view()->exists($resume->template->view_name))
            @include($resume->template->view_name, ['resume' => $resume])
        @else
            {{-- Fallback to a default basic rendering or a message --}}
            <div class="alert alert-warning">
                Selected template view '{{ $resume->template->view_name ?? 'N/A' }}' not found or no template selected. Displaying basic data.
            </div>
            {{-- You could include a very basic default template here as a fallback --}}
            @include('resumes.templates.simple_ats', ['resume' => $resume]) {{-- Fallback to simple_ats --}}
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Potentially add styles to constrain the preview area if templates are very wide */
    .resume-preview-area {
        /* max-width: 8.5in; /* Example: letter size width */
        /* margin: auto; */
    }
</style>
@endpush

@push('scripts')
<script>
    // Any JS specific to the preview page, e.g., for dynamic template switching if implemented later
</script>
@endpush
