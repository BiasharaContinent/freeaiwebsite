@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('Edit Resume: ') }} {{ $resume->title }}</h1>
    <form action="{{ route('resumes.update', $resume->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('resumes._form', ['resume' => $resume, 'skillTypes' => $skillTypes ?? []])
    </form>
</div>
@endsection
