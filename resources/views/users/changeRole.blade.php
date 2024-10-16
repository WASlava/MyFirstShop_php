@extends('layouts.myLayout')

@section('content')
    <h1>Change Role for {{ $user->name }}</h1>

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

    <!-- Форма для зміни ролі користувача -->
    <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="currentRole">Current Role:</label>
            <input type="text" class="form-control" id="currentRole" value="{{ $user->roles->pluck('name')->join(', ') }}" readonly>
        </div>

        <div class="form-group">
            <label for="role">Select New Role:</label>
            <select name="role" id="role" class="form-control">
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
