@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('My Resumes') }}
                    <a href="{{ route('resumes.create') }}" class="btn btn-primary btn-sm float-right">{{ __('Create New Resume') }}</a>
                </div>

                <div class="card-body">
                    @if($resumes->isEmpty())
                        <p>{{ __("You haven't created any resumes yet.") }}</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Format') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Last Updated') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resumes as $resume)
                                    <tr>
                                        <td>{{ $resume->title }}</td>
                                        <td>{{ ucfirst($resume->format_type) }}</td>
                                        <td>{{ $resume->is_draft ? 'Draft' : 'Published' }}</td>
                                        <td>{{ $resume->updated_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('resumes.edit', $resume) }}" class="btn btn-sm btn-info">{{ __('Edit') }}</a>
                                            <a href="{{ route('resumes.show', $resume) }}" class="btn btn-sm btn-secondary">{{ __('Preview') }}</a>
                                            <form action="{{ route('resumes.destroy', $resume) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this resume?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $resumes->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
