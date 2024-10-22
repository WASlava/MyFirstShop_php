@extends('layouts.myLayout')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <h1>Edit Profile</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.updateInf') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Login</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->info->first_name ?? '') }}">
                @error('first_name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->info->last_name ?? '') }}">
                @error('last_name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday', $user->info->birthday ? \Carbon\Carbon::parse($user->info->birthday)->format('Y-m-d') : '') }}">
                @error('birthday')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Поля для адреси --}}
            <div class="mb-3">
                <label for="address_line1" class="form-label">Address Line 1</label>
                <input type="text" class="form-control" id="address_line1" name="address_line1" value="{{ old('address_line1', $user->info->address_line1 ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="address_line2" class="form-label">Address Line 2</label>
                <input type="text" class="form-control" id="address_line2" name="address_line2" value="{{ old('address_line2', $user->info->address_line2 ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $user->info->city ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="postal_code" class="form-label">Postal Code</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->info->postal_code ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $user->info->country ?? '') }}">
            </div>

            {{-- Нове поле для телефону --}}
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->info->phone ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password (optional)</label>
                <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="new-password" placeholder="Leave blank if you don't want to change it">
                @error('current_password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password (optional)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank if you don't want to change it">
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Leave blank if you don't want to change it">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="{{ route('account.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
