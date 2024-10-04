@extends('layouts.myLayout')

@section('title', 'Home Page')

@section('content')
    <div class="text-center">
        <h1 class="display-4">Welcome to "My online store"</h1>
    </div>

    <h2>Favorite products</h2>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
        @foreach ($products->where('is_favorite', true) as $product)
            <div class="col col-sm col-md">
                <a href="{{ route('products.show', ['product' => $product->id]) }}">
                    @include('partials._product_card', ['product' => $product])
                </a>
            </div>
        @endforeach
    </div>
@endsection
