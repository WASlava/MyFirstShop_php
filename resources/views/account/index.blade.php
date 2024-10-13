@extends('layouts.myLayout')

@section('title', 'Profile')

@section('content')
    <div class="container">
        <h1>Profile Information</h1>

        <div class="mb-4">
            <strong>Login:</strong> {{ $user->name }}<br>
            <strong>Email:</strong> {{ $user->email }}<br>

            {{-- Додані поля з Info --}}
            @if($user->info)
            <?php $UsInf=$user->info ?>
                <strong>First Name:</strong> {{ $UsInf->first_name }}<br>
                <strong>Last Name:</strong> {{ $UsInf->last_name }}<br>
                <strong>Birthday:</strong>
                {{
                    $UsInf->birthday
                    ? (\Carbon\Carbon::parse($UsInf->birthday)->format('Y-m-d'))
                    : 'Not specified'
                }}<br>
                <strong>Address:</strong>
                    {{ $UsInf->address_line1 }}
                    {{ $UsInf->address_line2 }},
                    {{ $UsInf->city }},
                    {{ $UsInf->postal_code }},
                    {{ $UsInf->country }}<br>

                <strong>Phone:</strong> {{ $user->info->phone }}<br>
                <strong>Status:</strong> {{ $user->info->is_active ? 'Active' : 'Inactive' }}<br>

            @else
                <p>No additional information available.</p>
            @endif
        </div>

        <a href="{{ route('profile.editInf') }}" class="btn btn-primary">Edit Profile</a>
    </div>
@endsection
