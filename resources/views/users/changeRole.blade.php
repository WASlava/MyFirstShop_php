@extends('layouts.myLayout')

@section('content')
    <h1>Change Role for {{ $user->name }}</h1>

    <!-- Додаткова інформація з таблиці infos -->
    @if($user->info)
        <h3>Additional Information</h3>
        <p>First Name: {{ $user->info->first_name ?? 'N/A' }}</p>
        <p>Last Name: {{ $user->info->last_name ?? 'N/A' }}</p>
        <p>Birthday: {{ $user->info->birthday ?? 'N/A' }}</p>
        <p>Telephone: {{ $user->info->telephone ?? 'N/A' }}</p>
        <p>Address: {{ $user->info->address ?? 'N/A' }}</p>
        <p>Active Status: {{ $user->info->is_active ? 'Active' : 'Inactive' }}</p>
    @else
        <p>No additional information available.</p>
    @endif

    <!-- Форма для зміни ролі користувача -->
    <form action="{{ route('users.changeRole', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="currentRole">Current Role:</label>
            <input type="text" class="form-control" id="currentRole" value="{{ $user->roles->pluck('name')->join(', ') }}" readonly>
        </div>

        <div class="form-group">
            <label for="newRole">Select New Role:</label>
            <select name="newRole" id="newRole" class="form-control">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Change Role</button>
    </form>

    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Back to List</a>
@endsection
