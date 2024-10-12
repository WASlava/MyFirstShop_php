@extends('layouts.myLayout')

@section('content')
    <h1>Edit User {{ $user->name }}</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Login Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" class="form-control">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <!-- Додаткова інформація з таблиці infos -->
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->info->first_name ?? '') }}">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->info->last_name ?? '') }}">
        </div>

        <div class="form-group">
            <label for="birthday">Birthday</label>
            <input type="date" name="birthday" class="form-control" value="{{ old('birthday', isset($user->info) && $user->info->birthday ? date('Y-m-d', strtotime($user->info->birthday)) : '') }}">
        </div>

        <div class="form-group">
            <label for="telephone">Telephone</label>
            <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $user->info->telephone ?? '') }}">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $user->info->address ?? '') }}">
        </div>

        <div class="form-group">
            <label for="is_active">Is Active</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ old('is_active', $user->info->is_active ?? 0) == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active', $user->info->is_active ?? 0) == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to list</a>
@endsection
