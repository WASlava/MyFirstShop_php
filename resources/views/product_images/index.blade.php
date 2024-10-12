@extends('layouts.myLayout')

@section('title', 'Product Images')

@section('content')
    <div class="container">
        <h1 class="mb-4">Product Images</h1>

        {{-- Кнопка для додавання нового зображення --}}
        <p>
            <a href="{{ route('product_images.create') }}" class="btn btn-primary">Add Image</a>
        </p>

        {{-- Фільтр для пошуку по назві продукту --}}
        <p>
            <input type="text" id="filterInput" placeholder="Filter by product title" class="form-control" />
        </p>

        {{-- Таблиця зі списком зображень --}}
        <table class="table table-striped" id="imageTable">
            <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Image</th>
                <th>Is Default</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($images as $image)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $image->product->name ?? 'No Product' }}</td>
                    <td style="width: 120px; height: 120px;">
                        <img src="{{ $image->src }}" alt="{{ $image->product->name ?? 'No Image' }}" class="img-fluid" style="max-width: 100%; max-height: 100px; object-fit: contain;" />
                    </td>
                    <td>
                        @if ($image->is_default)
                            <span class="badge bg-success">Default</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        {{-- Кнопка для встановлення за замовчуванням --}}
                        @if (!$image->is_default)
                            <a href="{{ route('product_images.set_default', $image->id) }}" class="btn btn-sm btn-outline-success">Set Default</a>
                        @endif

                        {{-- Кнопки для редагування та видалення --}}
                        <a href="{{ route('product_images.edit', $image->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                        <form action="{{ route('product_images.destroy', $image->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this image?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        // Фільтрація зображень по назві продукту
        document.getElementById('filterInput').addEventListener('keyup', function() {
            var filterValue = this.value.toLowerCase();
            var rows = document.querySelectorAll('#imageTable tbody tr');

            rows.forEach(function(row) {
                var productTitle = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (productTitle.includes(filterValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
