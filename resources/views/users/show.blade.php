@extends('layouts.myLayout')

@section('content')
    <h1>Details for {{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>
    <p>Created at: {{ $user->created_at }}</p>
    <p>Updated at: {{ $user->updated_at }}</p>

    <!-- Додаткова інформація з таблиці infos -->
    @if($user->info)
            <?php $UsInf=$user->info ?>
        <strong>First Name:</strong> {{ $UsInf->first_name ?? 'N/A'  }}<br>
        <strong>Last Name:</strong> {{ $UsInf->last_name ?? 'N/A'  }}<br>
        <strong>Birthday:</strong>
        {{
            $UsInf->birthday
            ? (\Carbon\Carbon::parse($UsInf->birthday)->format('Y-m-d'))
            : 'Not specified'
        }}<br>
        <strong>Address:</strong>
        {{ $UsInf->address_line1 ?? ''}}
        {{ $UsInf->address_line2 ?? ''}},
        {{ $UsInf->city ?? ''}},
        {{ $UsInf->postal_code ?? ''}},
        {{ $UsInf->country ?? ''}}<br>

        <strong>Phone:</strong> {{ $UsInf->phone ?? 'N/A'  }}<br>
        <strong>Status:</strong> {{ $UsInf->is_active ? 'Active' : 'Inactive' }}<br>

    @else
        <p>No additional information available.</p>
    @endif


    <a href="{{ route('users.index') }}" class="btn btn-primary">Back to list</a>
@endsection

