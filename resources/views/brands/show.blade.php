@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Brand Details</h1>
        <div class="card">
            <div class="card-body">
                <h3>{{ $brand->brand_name }}</h3>
                <p><strong>Country:</strong> {{ $brand->country }}</p>
                <a href="{{ route('brands.index') }}" class="btn btn-secondary">Back to Brands List</a>
            </div>
        </div>
    </div>
@endsection
