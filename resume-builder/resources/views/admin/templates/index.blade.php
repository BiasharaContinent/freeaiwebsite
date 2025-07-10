@extends('layouts.admin')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Manage Resume Templates</h1>
        <a href="{{ route('admin.templates.create') }}" class="btn btn-primary">Create New Template</a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($templates->isEmpty())
                <p>No templates found. <a href="{{ route('admin.templates.create') }}">Create one now</a>.</p>
            @else
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Preview</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>View Name</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($templates as $template)
                            <tr>
                                <td>
                                    @if($template->preview_image_path)
                                        <img src="{{ asset('storage/' . $template->preview_image_path) }}" alt="{{ $template->name }} preview" style="max-height: 50px; max-width: 70px; border:1px solid #eee;">
                                    @else
                                        <span class="text-muted small">No Preview</span>
                                    @endif
                                </td>
                                <td>{{ $template->name }}</td>
                                <td><span class="badge badge-{{ $template->type == 'ats' ? 'info' : 'success' }}">{{ ucfirst($template->type) }}</span></td>
                                <td><code>{{ $template->view_name }}</code></td>
                                <td>
                                    @if($template->is_active)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.templates.edit', $template) }}" class="btn btn-sm btn-info" title="Edit">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.templates.destroy', $template) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this template? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $templates->links() }}
            @endif
        </div>
    </div>
@endsection
