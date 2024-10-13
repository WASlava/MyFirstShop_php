@extends('layouts.myLayout')

@section('content')
    <h1>Change Password for {{ $user->name }}</h1>

    <form action="{{ route('users.updatePassword', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to list</a>
@endsection
