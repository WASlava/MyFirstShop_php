@extends('layouts.myLayout')

@section('content')
    <h1>Create Product</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            @error('title')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}">
            @error('price')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            @error('description')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="brand_id">Brand</label>
            <select name="brand_id" class="form-control">
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">
                        {{ $brand->brand_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <input type="checkbox" name="is_favorite" class="form-check-input" id="is_favorite" value="1" {{ old('is_favorite') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_favorite">Is Favorite</label>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>

    <div>
        <a href="{{ route('products.index') }}">Back to List</a>
    </div>
@endsection
