@extends('layouts.myLayout')

@section('content')
    <h1>{{ $product->category->category_name }} {{ $product->brand->brand_name }} {{ $product->title }}</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-6 big-picture bordBig">
                @if ($product->images->count())
                    @php
                        $defaultImage = $product->images->firstWhere('is_default', true) ?? $product->images->first();
                    @endphp
                    <img id="bigImage" src="data:image/*;base64,{{ base64_encode($defaultImage->image_data) }}" class="big-img" alt="Big Product Image" />
                @else
                    <img id="bigImage" src="{{ asset('images/no-img.jpg') }}" class="big-img" alt="No Image Available" />
                @endif
            </div>
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-4">
                        {{ __('Description') }}
                    </dt>
                    <dd class="col-sm-8">
                        {{ $product->description }}
                    </dd>
                </dl>
                <hr />
                <div class="small-picture">
                    @if ($product->images && $product->images->count())
                        @foreach ($product->images as $image)
                            @php
                                $imageSrc = "data:image/*;base64," . base64_encode($image->image_data);
                            @endphp
                            <figure>
                                <img class="bordSmall small-img" src="{{ $imageSrc }}" alt="Product Image" onclick="document.getElementById('bigImage').src='{{ $imageSrc }}';" />
                            </figure>
                        @endforeach
                    @else
                        <p>No images available for this product.</p>
                    @endif
                </div>
                <hr />
                <div class="price-cart-container">
                    <p class="card-text">{{ $product->price }} &#8372;</p>
                    <form action="{{route('cart.add', ['id' => $product->id, 'returnUrl' => request()->fullUrl()]) }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="returnUrl" value="{{ request()->fullUrl() }}">
                        <button type="submit" class="btn btn-outline-primary" title="Add to Cart">
                            <svg style="width: 100%; height: 100%;" width="40" height="30" fill="currentColor" class="bi bi-cart" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">--}}
                                <path d="M11 7h1a.5.5 0 1 1 0 1h-1v1a.5.5 0 1 1-1 0V8H9a.5.5 0 0 1 0-1h1V6a.5.5 0 1 1 1 0v1zM5.323 4H8a.5.5 0 0 1 0 1H5.532l1.25 6h7.314l1.286-6H13a.5.5 0 1 1 0-1h3a.5.5 0 0 1 .489.605l-1.5 7A.5.5 0 0 1 14.5 12H6.99l.417 2H14a2 2 0 1 1-1.733 1H8.733a2 2 0 1 1-2.329-.91L4.094 3H2.5a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .49.398L5.322 4zM8 16a1 1 0 1 0-1.999-.001A1 1 0 0 0 8 16zm7 0a1 1 0 1 0-1.999-.001A1 1 0 0 0 15 16z"></path>
                            </svg>
                        </button>
                    </form>

                    {{--                    <a href="{{ route('cart.add', ['id' => $product->id, 'returnUrl' => request()->fullUrl()]) }}" class="btn btn-outline-primary" title="Add to Cart">--}}
{{--                        <svg style="width: 100%; height: 100%;" width="40" height="30" fill="currentColor" class="bi bi-cart" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">--}}
{{--                            <path d="M11 7h1a.5.5 0 1 1 0 1h-1v1a.5.5 0 1 1-1 0V8H9a.5.5 0 0 1 0-1h1V6a.5.5 0 1 1 1 0v1zM5.323 4H8a.5.5 0 0 1 0 1H5.532l1.25 6h7.314l1.286-6H13a.5.5 0 1 1 0-1h3a.5.5 0 0 1 .489.605l-1.5 7A.5.5 0 0 1 14.5 12H6.99l.417 2H14a2 2 0 1 1-1.733 1H8.733a2 2 0 1 1-2.329-.91L4.094 3H2.5a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .49.398L5.322 4zM8 16a1 1 0 1 0-1.999-.001A1 1 0 0 0 8 16zm7 0a1 1 0 1 0-1.999-.001A1 1 0 0 0 15 16z"></path>--}}
{{--                        </svg>--}}
{{--                    </a>--}}
                </div>
            </div>
        </div>
        <hr />

        @if (auth()->user() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Manager')))
            <div>
                <a href="{{ route('products.edit', $product->id) }}">Edit</a> |
                <a href="{{ route('products.index') }}">Back to List</a>
            </div>
        @else
            <div>
                <a href="{{ route('products.index') }}">Back to List</a>
            </div>
        @endif
    </div>
@endsection
