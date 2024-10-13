@extends('layouts.myLayout')

@section('title', 'Edit Product Image')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Product Image</h1>

        {{-- Відображення попереднього зображення --}}
        <div class="mb-4">
            @if ($image->filename)
                <img src="{{ Storage::url('images/' . $image->product->category->category_name . '/' . $image->product->brand->brand_name . '/' . $image->filename) }}" alt="{{ $image->product->title ?? 'No Image' }}" class="img-fluid" style="max-width: 300px; max-height: 300px; object-fit: contain;" />
            @else
                <p>No image available</p>
            @endif
        </div>

        <form action="{{ route('product_images.update', $image->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="image" class="form-label">Select a new image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Image</button>
            <a href="{{ route('product_images.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
