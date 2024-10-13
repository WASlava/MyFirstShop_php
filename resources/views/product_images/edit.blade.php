@extends('layouts.myLayout')

@section('title', 'Edit Product Image')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Product Image</h1>

        {{-- Відображення попереднього зображення --}}
        <div class="mb-4 d-flex">
            @if ($image->filename)
                <div>
                    <h5>Current Image:</h5>
                    <img src="{{ Storage::url('images/' . $image->product->category->category_name . '/' . $image->product->brand->brand_name . '/' . $image->filename) }}" alt="{{ $image->product->title ?? 'No Image' }}" class="img-fluid" style="max-width: 300px; max-height: 300px; object-fit: contain;" />
                </div>
            @else
                <p>No image available</p>
            @endif

            {{-- Відображення нового зображення --}}
            <div class="ml-4">
                <h5>New Image Preview:</h5>
                <img id="newImagePreview" src="#" alt="New Image Preview" class="img-fluid" style="max-width: 300px; max-height: 300px; object-fit: contain; display: none;" />
            </div>
        </div>

        <form action="{{ route('product_images.update', $image->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="image" class="form-label">Select a new image</label>
                <input type="file" class="form-control" id="image" name="image" required accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Update Image</button>
            <a href="{{ route('product_images.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection

@section('end_scripts')
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const newImagePreview = document.getElementById('newImagePreview');
                    newImagePreview.src = e.target.result; // Встановлюємо нове зображення як джерело
                    newImagePreview.style.display = 'block'; // Показуємо нове зображення
                };
                reader.readAsDataURL(file); // Читаємо файл як Data URL
            }
        });
    </script>
@endsection
