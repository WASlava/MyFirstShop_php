@extends('layouts.myLayout')

@section('content')
    <h4>Create Role</h4>
    <hr />
    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name" class="control-label">Role Name</label>
                    <input type="text" name="name" class="form-control" />
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" value="Create" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>

    <div>
        <a href="{{ route('roles.index') }}">Back to List</a>
    </div>
@endsection
