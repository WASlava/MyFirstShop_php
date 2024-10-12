@extends('layouts.myLayout')

@section('title', 'Create Product Image')

@section('content')
    <div class="container">
        <h1 class="mb-4">Add New Product Image</h1>

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

        {{-- Форма для завантаження зображення --}}
        <form action="{{ route('product_images.create') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="categoryId" class="form-label">Category</label>
                <select name="category_id" id="categoryId" class="form-control" onchange="onCategoryChange(event)">
                    <option value="">Select a Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3" id="brandsDiv"></div>
            <div class="mb-3" id="productsDiv"></div>

            <div class="mb-3">
                <label for="photosInp" class="form-label">Upload Photos</label>
                <input type="file" accept="image/*" multiple name="photos[]" id="photosInp" class="form-control" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_default" name="is_default">
                <label class="form-check-label" for="is_default">Set as Default Image</label>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>

    <a href="{{ route('product_images.index') }}" class="btn btn-link mt-3">Back to List</a>
@endsection

@section('end_scripts')
    <script type="text/javascript">
        var catId;
        var brandId;

        // Функція onCategoryChange в глобальному контексті
        async function onCategoryChange(e) {
            let categoryId = e.target.value;
            catId = categoryId;
            let text = await getBrandsByCategory(categoryId);
            console.log("-------------------");
            console.log(text);
            let div = document.createElement("div");
            let categoriesDiv = e.target.parentElement;
            div.innerHTML = text;
            let brandsDiv = document.getElementById("brandsDiv");
            if (brandsDiv) {
                brandsDiv.replaceWith(div.firstElementChild);
                let productsDiv = document.getElementById("productsDiv");
                if (productsDiv)
                    productsDiv.remove();
            }
            else categoriesDiv.after(div.firstChild);
        }
        async function getBrandsByCategory(categoryId) {
            let resp = await fetch(`/product_images/getBrandsByCategory/${categoryId}`, {
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    "accept": "text/html"
                }
            });
            if (resp.ok === true) {
                let textData = await resp.text();
                console.log(textData);
                return textData;
            }
        }
        async function onBrandChange(e) {
            let brandId = e.target.value;
            console.log(brandId);
            let text = await getProducts(catId, brandId);
            let div = document.createElement("div");
            div.innerHTML = text;
            let productsDiv = document.getElementById("productsDiv");
            let brandsDiv = document.getElementById("brandsDiv");
            if (productsDiv)
                productsDiv.replaceWith(div.firstElementChild);
            else brandsDiv.after(div.firstChild);
        }
        async function getProducts(categoryId, brandId) {
            let bodyData = JSON.stringify({
                categoryId: categoryId,
                brandId: brandId
            });
            console.log(bodyData);
            let resp = await fetch("/product_images/getProducts", {
                method: "post",
                headers: {
                    "content-type": "application/json",
                    "accept": "text/html"
                },
                body: bodyData
            });
            if (resp.ok == true) {
                let textData = await resp.text();
                console.log(textData);
                return textData;
            } else {
                console.error("Error fetching brands:", resp.status); // Виводимо помилку, якщо є
            }
        }

        // Додаємо обробник подій при завантаженні DOM
        document.addEventListener('DOMContentLoaded', function () {
            // Якщо потрібно, ви можете ініціалізувати тут деякі елементи
        });
            </script>
@endsection
{{--    <div class="container">--}}
{{--        <h1 class="mb-4">Add New Product Image</h1>--}}

{{--        --}}{{-- Виведення помилок --}}
{{--        @if ($errors->any())--}}
{{--            <div class="alert alert-danger">--}}
{{--                <ul>--}}
{{--                    @foreach ($errors->all() as $error)--}}
{{--                        <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        --}}{{-- Форма для додавання зображення --}}
{{--        <form action="{{ route('product_images.store') }}" method="POST" enctype="multipart/form-data">--}}
{{--            @csrf--}}

{{--            <div class="mb-3">--}}
{{--                <label for="product_id" class="form-label">Product</label>--}}
{{--                <select name="product_id" id="product_id" class="form-control" required>--}}
{{--                    <option value="">Select a Product</option>--}}
{{--                    @foreach ($products as $product)--}}
{{--                        <option value="{{ $product->id }}">{{ $product->name }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}

{{--            <div class="mb-3">--}}
{{--                <label for="image" class="form-label">Image</label>--}}
{{--                <input type="file" name="image" id="image" class="form-control-file" required>--}}
{{--            </div>--}}

{{--            <div class="mb-3 form-check">--}}
{{--                <input type="checkbox" class="form-check-input" id="is_default" name="is_default">--}}
{{--                <label class="form-check-label" for="is_default">Set as Default Image</label>--}}
{{--            </div>--}}

{{--            <button type="submit" class="btn btn-primary">Upload Image</button>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--@endsection--}}
