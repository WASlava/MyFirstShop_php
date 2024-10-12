@extends('layouts.myLayout')

@section('title', 'Edit Product Image')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Product Image</h1>

        {{-- Виведення помилок --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Форма для редагування зображення --}}
        <form action="{{ route('product_images.update', $image->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="product_id" class="form-label">Product</label>
                <select name="product_id" id="product_id" class="form-control" required>
                    <option value="">Select a Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $product->id == $image->product_id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Replace Image (optional)</label>
                <input type="file" name="image" id="image" class="form-control-file">
                <p class="form-text">Current Image:</p>
                <img src="{{ $image->src }}" alt="{{ $image->product->name }}" class="img-fluid" style="max-width: 100px; object-fit: contain;">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_default" name="is_default" {{ $image->is_default ? 'checked' : '' }}>
                <label class="form-check-label" for="is_default">Set as Default Image</label>
            </div>

            <button type="submit" class="btn btn-primary">Update Image</button>
        </form>
    </div>
@endsection
