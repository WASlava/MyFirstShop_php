@extends('layouts.myLayout')

@section('title', 'Product Images')

@section('content')
    <div class="container">
        <h1 class="mb-4">Product Images</h1>

        {{-- Кнопка для додавання нового зображення --}}
        <p>
            <a href="{{ route('product_images.create') }}" class="btn btn-primary">Add Image</a>
        </p>

        {{-- Фільтр для пошуку по назві продукту, категорії та бренду --}}
        <p>
            <input type="text" id="filterInput" placeholder="Filter by product title, category or brand" class="form-control" />
        </p>

        {{-- Переглядаємо всі продукти --}}
        @foreach ($products as $product)
            <div class="product-section mb-4">
                {{-- Назва продукту разом з категорією та брендом --}}
                <h3 class="product-title" data-title="{{ $product->title }}" data-category="{{ $product->category->category_name }}" data-brand="{{ $product->brand->brand_name }}">
                    {{ $product->title }} ({{ $product->category->category_name }} - {{ $product->brand->brand_name }})
                </h3>

                {{-- Всі зображення для продукту --}}
                <div class="product-images d-flex flex-wrap">
                    @foreach ($product->images as $image)
                        <div class="product-image-box text-center" style="margin-right: 10px;">
                            <img src="{{ Storage::url('images/' . $product->category->category_name . '/' . $product->brand->brand_name . '/' . $image->filename) }}" alt="{{ $product->title }}" style="height: 100px; width: auto; object-fit: contain;" />

                            {{-- Кнопка для встановлення зображення за замовчуванням, якщо це не дефолтне зображення --}}
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                {{-- Радіокнопка для вибору зображення --}}
                                <input type="radio" name="selected_image_{{ $product->id }}" value="{{ $image->id }}" style="margin-top: 2px;">

                                @if (!$image->is_default)
                                    <form action="{{ route('product_images.set_default', $image->id) }}" method="POST" style="margin-left: 5px;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" style="font-size: 10px; padding: 2px 6px;">Set Default</button>
                                    </form>
                                @else
                                    <form action="#" style="height: 25px; margin-left: 5px;"></form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Кнопки для редагування та видалення обраного зображення --}}
                <div class="action-buttons mt-3">
                    <a href="#" id="edit-btn-{{ $product->id }}" class="btn btn-sm btn-outline-primary disabled">Edit</a>

                    <form action="#" method="POST" class="d-inline-block" id="delete-form-{{ $product->id }}" onsubmit="return confirm('Are you sure you want to delete this image?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger disabled">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('end_scripts')
    <script>
        // Пошук по назві продукту, категорії та бренду
        document.getElementById('filterInput').addEventListener('keyup', function() {
            var filterValue = this.value.toLowerCase();
            var productSections = document.querySelectorAll('.product-section');

            productSections.forEach(function(section) {
                var title = section.querySelector('.product-title').dataset.title.toLowerCase();
                var category = section.querySelector('.product-title').dataset.category.toLowerCase();
                var brand = section.querySelector('.product-title').dataset.brand.toLowerCase();

                // Перевіряємо, чи входить значення фільтру в назву, категорію або бренд
                if (title.includes(filterValue) || category.includes(filterValue) || brand.includes(filterValue)) {
                    section.style.display = ''; // Показуємо продукт
                } else {
                    section.style.display = 'none'; // Сховуємо продукт
                }
            });
        });

        // Для кожного продукту ми додаємо обробник радіокнопок
        @foreach ($products as $product)
        document.querySelectorAll('input[name="selected_image_{{ $product->id }}"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var imageId = this.value;

                var editButton = document.getElementById('edit-btn-{{ $product->id }}');
                var deleteForm = document.getElementById('delete-form-{{ $product->id }}');

                editButton.href = '/product_images/' + imageId + '/edit';
                deleteForm.action = '/product_images/' + imageId;

                editButton.classList.remove('disabled');
                deleteForm.querySelector('button').classList.remove('disabled');
            });
        });
        @endforeach
    </script>
@endsection
