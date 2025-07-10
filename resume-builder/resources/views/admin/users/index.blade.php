@extends('layouts.admin')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Manage Users</h1>
        {{-- <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create New User</a> --}}
        {{-- Admin user creation disabled for now --}}
    </div>

    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.users.index') }}" class="form-inline">
                <div class="form-group mr-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search name or email..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-sm btn-secondary">Search</button>
                 @if(request('search'))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light ml-2">Clear</a>
                @endif
            </form>
        </div>
        <div class="card-body">
            @if($users->isEmpty())
                <p>No users found.</p>
            @else
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Resumes</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->getRoleNames() as $role)
                                        <span class="badge badge-info mr-1">{{ $role }}</span>
                                    @endforeach
                                    @if($user->getRoleNames()->isEmpty())
                                        <span class="badge badge-secondary">None</span>
                                    @endif
                                </td>
                                <td>{{ $user->resumes_count ?? $user->resumes()->count() }}</td> {{-- Assuming resumes_count might be added with withCount later --}}
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info" title="Edit Roles">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg>
                                    </a>
                                    @if(Auth::user()->id !== $user->id) {{-- Prevent self-delete button --}}
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user? This will also delete all their resumes.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->appends(request()->query())->links() }} {{-- Append search query to pagination --}}
            @endif
        </div>
    </div>
@endsection
