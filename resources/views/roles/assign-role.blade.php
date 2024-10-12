@extends('layouts.myLayout')

@section('content')
    <h1>Assign Role to User</h1>
    <form action="{{ route('users.assign-role', $user->id) }}" method="POST">
        @csrf
        <select name="role">
            @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
        <button type="submit">Assign Role</button>
    </form>
@endsection
