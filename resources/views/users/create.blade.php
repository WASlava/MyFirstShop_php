@extends('layouts.myLayout')

@section('content')
    <h1>Create New User</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Login Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control">
        </div>

         <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <!-- Додаткова інформація з таблиці infos -->
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
        </div>

        <div class="form-group">
            <label for="birthday">Birthday</label>
            <input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}">
        </div>

        <div class="form-group">
            <label for="telephone">Telephone</label>
            <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
        </div>

        <div class="form-group">
            <label for="is_active">Is Active</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to list</a>
@endsection
