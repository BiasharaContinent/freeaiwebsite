@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('Create New Resume') }}</h1>
    <form action="{{ route('resumes.store') }}" method="POST" enctype="multipart/form-data">
        @include('resumes._form', ['resume' => null, 'skillTypes' => $skillTypes ?? []])
    </form>
</div>
@endsection
