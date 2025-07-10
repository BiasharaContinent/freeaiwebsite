@extends('layouts.admin')

@section('admin_content')
    <h1 class="h3 mb-3">User Details: {{ $user->name }}</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">User Information</div>
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $user->id }}</p>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Email Verified:</strong> {{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : 'No' }}</p>
                    <p><strong>Joined:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                    <p><strong>Roles:</strong>
                        @forelse($user->getRoleNames() as $role)
                            <span class="badge badge-info mr-1">{{ $role }}</span>
                        @empty
                            <span class="badge badge-secondary">None</span>
                        @endforelse
                    </p>
                     <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-info mt-2">Edit User Roles</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">User Resumes ({{ $user->resumes->count() }})</div>
                <div class="card-body">
                    @if($user->resumes->isEmpty())
                        <p>This user has not created any resumes yet.</p>
                    @else
                        <ul class="list-group">
                            @foreach($user->resumes as $resume)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('resumes.show', $resume) }}" target="_blank">{{ $resume->title }}</a>
                                    <small class="text-muted">Last updated: {{ $resume->updated_at->format('Y-m-d') }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to User List</a>
    </div>
@endsection
