@extends('layouts.admin')

@section('admin_content')
    <h1 class="h3 mb-3">Edit User: {{ $user->name }}</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">User Details & Roles</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password (Optional - leave blank to keep current)') }}</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <hr>
                <h5>{{ __('Assign Roles') }}</h5>
                <div class="form-group">
                    @forelse ($roles as $roleName)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $roleName }}" id="role_{{ $roleName }}"
                                   @if(in_array($roleName, old('roles', $user->getRoleNames()->toArray()))) checked @endif
                                   @if($user->id === Auth::user()->id && $roleName === 'Admin' && App\Models\User::role('Admin')->count() <= 1)
                                       onclick="return false;" title="Cannot remove your own Admin role as the only Admin."
                                   @endif
                                   >
                            <label class="form-check-label" for="role_{{ $roleName }}">
                                {{ ucfirst($roleName) }}
                            </label>
                             @if($user->id === Auth::user()->id && $roleName === 'Admin' && App\Models\User::role('Admin')->count() <= 1)
                                <small class="text-muted d-block">(You cannot uncheck your own 'Admin' role as you are the only Admin.)</small>
                            @endif
                        </div>
                    @empty
                        <p>No roles defined. Please seed roles first.</p>
                    @endforelse
                    @error('roles') <span class="text-danger d-block">{{ $message }}</span> @enderror
                     @error('roles.*') <span class="text-danger d-block">{{ $message }}</span> @enderror
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">{{ __('Update User') }}</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </div>
        </div>
    </form>
@endsection
