@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Create New Brand</h1>
        <form action="{{ route('brands.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="brand_name">Brand Name</label>
                <input type="text" class="form-control" id="brand_name" name="brand_name" value="{{ old('brand_name') }}" required>
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" required>
            </div>
            <button type="submit" class="btn btn-success">Create Brand</button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
