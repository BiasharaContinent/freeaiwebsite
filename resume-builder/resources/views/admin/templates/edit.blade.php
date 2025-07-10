@extends('layouts.admin')

@section('admin_styles')
    {{-- Add any specific styles for this page if needed --}}
@endsection

@section('admin_content')
    <h1 class="h3 mb-3">Edit Template: {{ $template->name }}</h1>

    <form action="{{ route('admin.templates.update', $template) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.templates._form', ['template' => $template, 'templateTypes' => $templateTypes])
    </form>
@endsection

@section('admin_scripts')
    {{-- Add any specific scripts for this page if needed --}}
@endsection
