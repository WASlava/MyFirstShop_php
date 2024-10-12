@extends('layouts.myLayout')

@section('content')
    <h1>Edit Role</h1>
    <h4>Here you can change the name of role: {{ $role->name }}</h4>
    <hr />
    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name" class="control-label">Role Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $role->name }}" />
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" value="Save" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>

    <div>
        <a href="{{ route('roles.index') }}">Back to List</a>
    </div>
@endsection
