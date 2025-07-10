@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('AI Resume Builder - Upload Your Resume') }}</div>

                <div class="card-body">
                    <p class="mb-4">
                        Upload your existing resume (PDF format) to get started. Our AI will attempt to extract the content
                        and help you build a new resume or improve your current one.
                    </p>

                    <form action="{{ route('ai.parse') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="resume_pdf" class="col-md-4 col-form-label text-md-right">{{ __('Resume PDF') }}</label>

                            <div class="col-md-6">
                                <input id="resume_pdf" type="file" class="form-control-file @error('resume_pdf') is-invalid @enderror" name="resume_pdf" required accept=".pdf">

                                @error('resume_pdf')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">Max file size: 5MB. Allowed type: .pdf</small>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Upload and Parse Resume') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 text-center">
                <p>Alternatively, you can <a href="{{ route('resumes.create') }}">skip this step and build your resume manually</a>.</p>
            </div>
        </div>
    </div>
</div>
@endsection
