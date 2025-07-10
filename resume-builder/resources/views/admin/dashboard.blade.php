@extends('layouts.admin')

@section('admin_content')
    <h1 class="mt-4">Admin Dashboard</h1>
    <p>Welcome to the admin panel. From here you can manage various aspects of the application.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">View, edit, or manage user accounts.</p>
                    {{-- <a href="{{ route('admin.users.index') }}" class="btn btn-light stretched-link disabled">Go to Users</a> --}}
                     <a href="#" class="btn btn-light stretched-link disabled">Go to Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Resume Templates</div>
                <div class="card-body">
                    <h5 class="card-title">Manage Templates</h5>
                    <p class="card-text">Add, edit, or delete resume templates.</p>
                    <a href="{{ route('admin.templates.index') }}" class="btn btn-light stretched-link">Go to Templates</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Analytics</div>
                <div class="card-body">
                    <h5 class="card-title">View Analytics</h5>
                    <p class="card-text">Check usage statistics and site performance.</p>
                    {{-- <a href="{{ route('admin.analytics') }}" class="btn btn-light stretched-link disabled">Go to Analytics</a> --}}
                     <a href="#" class="btn btn-light stretched-link disabled">Go to Analytics</a>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">
    <h3>Quick Statistics</h3>
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card bg-light mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $userCount ?? 'N/A' }}</h5>
                    <p class="card-text">Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $resumeCount ?? 'N/A' }}</h5>
                    <p class="card-text">Total Resumes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $activeTemplateCount ?? 'N/A' }} / {{ $totalTemplateCount ?? 'N/A' }}</h5>
                    <p class="card-text">Active / Total Templates</p>
                </div>
            </div>
        </div>
    </div>

    <h4>Resume Breakdown</h4>
    <div class="row mt-2">
        <div class="col-md-3">
            <div class="card bg-light mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $atsResumeCount ?? 'N/A' }}</h5>
                    <p class="card-text">ATS Formatted Resumes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $styledResumeCount ?? 'N/A' }}</h5>
                    <p class="card-text">Styled Formatted Resumes</p>
                </div>
            </div>
        </div>
         <div class="col-md-3">
            <div class="card bg-light mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $draftResumeCount ?? 'N/A' }}</h5>
                    <p class="card-text">Draft Resumes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $publishedResumeCount ?? 'N/A' }}</h5>
                    <p class="card-text">"Published" Resumes</p> {{-- Assuming is_draft=false means published --}}
                </div>
            </div>
        </div>
    </div>
@endsection
