@extends('layouts.admin')

@section('admin_styles')
    {{-- Add any specific styles for this page if needed --}}
@endsection

@section('admin_content')
    <h1 class="h3 mb-3">Create New Resume Template</h1>

    <form action="{{ route('admin.templates.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.templates._form', ['template' => null, 'templateTypes' => $templateTypes])
    </form>
@endsection

@section('admin_scripts')
    {{-- Add any specific scripts for this page if needed --}}
@endsection
