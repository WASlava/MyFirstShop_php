@extends('layouts.myLayout')

@section('content')
    <h1>Change Password for {{ $user->name }}</h1>

    <form action="{{ route('users.updatePassword', $user->id) }}" method="POST">
        @csrf
{{--        @method('PUT')--}}

{{--        <div class="form-group">--}}
{{--            <label for="current_password">Current Password</label>--}}
{{--            <input type="password" name="current_password" class="form-control">--}}
{{--        </div>--}}

        <div class="form-group">
            <label for="new-password">New Password</label>
            <input type="password" name="new-password" id="new-password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to list</a>
@endsection
