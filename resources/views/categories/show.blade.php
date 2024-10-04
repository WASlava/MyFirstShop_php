@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Category Details</h1>

        <div class="card">
            <div class="card-header">
                Category: {{ $category->category_name }}
            </div>
            <div class="card-body">
                <p><strong>ID: </strong>{{ $category->id }}</p>
                <p><strong>Name: </strong>{{ $category->category_name }}</p>
                <p><strong>Parent Category: </strong>{{ $category->parentCategory ? $category->parentCategory->category_name : 'None' }}</p>
            </div>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Back to Categories</a>
    </div>
@endsection
