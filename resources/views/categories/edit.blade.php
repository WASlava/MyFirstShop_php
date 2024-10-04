@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Edit Category</h1>

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" name="category_name" id="category_name" class="form-control" value="{{ old('category_name', $category->category_name) }}" required>
            </div>

            <div class="form-group mt-3">
                <label for="parent_category_id">Parent Category</label>
                <select name="parent_category_id" id="parent_category_id" class="form-control">
                    <option value="">None</option>
                    @foreach ($parentCategories as $parentCategory)
                        <option value="{{ $parentCategory->id }}" {{ $category->parent_category_id == $parentCategory->id ? 'selected' : '' }}>
                            {{ $parentCategory->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Back to Categories</a>
    </div>
@endsection
