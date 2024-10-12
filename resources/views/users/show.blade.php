@extends('layouts.myLayout')

@section('content')
    <h1>Details for {{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>
    <p>Created at: {{ $user->created_at }}</p>
    <p>Updated at: {{ $user->updated_at }}</p>

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

    <a href="{{ route('users.index') }}" class="btn btn-primary">Back to list</a>
@endsection

