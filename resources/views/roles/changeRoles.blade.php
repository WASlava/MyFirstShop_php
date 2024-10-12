@extends('layouts.myLayout')

@section('content')
    <h1>Change Roles for User</h1>
    <h4>Here you can change roles of User: {{ $user->email }}</h4>
    <hr />
    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('users.changeRoles', $user->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    @foreach ($allRoles as $roleName)
                        <div class="mb-3">
                            <input type="checkbox" class="form-check-input" name="roles[]" value="{{ $roleName }}"
                                {{ in_array($roleName, $userRoles) ? 'checked' : '' }} />
                            <span>{{ $roleName }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    <input type="submit" value="Save" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>

    <div>
        <a href="{{ route('users.index') }}">Back to List</a>
    </div>
@endsection
