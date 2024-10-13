{{--<div class="card m-4 product-card-link" style="width: 15rem; height: 25rem; text-align: center; display: flex; flex-direction: column;">--}}
{{--    @if ($model->images->isNotEmpty())--}}
{{--        @php--}}
{{--            $defaultImage = $model->images->firstWhere('is_default', true);--}}
{{--        @endphp--}}
{{--        @if ($defaultImage)--}}
{{--            <img src="{{ asset('storage/' . $defaultImage->filename) }}" alt="{{ $model->title }}" style="height: auto; width: 100%; object-fit: contain; margin: 5px 0 0 0;" />--}}
{{--        @else--}}
{{--            <img src="placeholder-image-url" alt="Default Image" style="height: auto; width: 100%; object-fit: contain; margin: 5px 0 0 0;" />--}}
{{--        @endif--}}
{{--    @else--}}
{{--        <img src="{{ asset('images/no-img.jpg') }}" alt="no-image" style="height: auto; width: 100%; object-fit: contain;" class="card-img-top" />--}}
{{--    @endif--}}

{{--    <div class="card-body" style="flex-grow: 1; margin-bottom: 10px;">--}}
{{--        <h5 class="card-title">{{ $model->brand->brand_name }} {{ $model->title }}</h5>--}}
{{--    </div>--}}

{{--        <div class="price-cart-container" style="margin-top: auto;">--}}
{{--            <p class="card-text">{{ $model->price }} &#8372;</p>--}}

{{--            <form action="{{ route('cart.add', ['id' => $model->id]) }}" method="POST" style="display: inline;">--}}
{{--                @csrf--}}
{{--                <input type="hidden" name="returnUrl" value="{{ request()->fullUrl() }}">--}}
{{--                <button type="submit" class="btn btn-outline-primary" title="Add to Cart">--}}
{{--                    <svg style="width: 100%; height: 100%;" width="40" height="30" fill="currentColor" class="bi bi-person-workspace" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">--}}
{{--                        <path d="M11 7h1a.5.5 0 1 1 0 1h-1v1a.5.5 0 1 1-1 0V8H9a.5.5 0 0 1 0-1h1V6a.5.5 0 1 1 1 0v1zM5.323 4H8a.5.5 0 0 1 0 1H5.532l1.25 6h7.314l1.286-6H13a.5.5 0 1 1 0-1h3a.5.5 0 0 1 .489.605l-1.5 7A.5.5 0 0 1 14.5 12H6.99l.417 2H14a2 2 0 1 1-1.733 1H8.733a2 2 0 1 1-2.329-.91L4.094 3H2.5a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .49.398L5.322 4zM8 16a1 1 0 1 0-1.999-.001A1 1 0 0 0 8 16zm7 0a1 1 0 1 0-1.999-.001A1 1 0 0 0 15 16z"></path>--}}
{{--                    </svg>--}}
{{--                </button>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--</div>--}}


<div class="card m-4 product-card-link" style="width: 15rem; height: 25rem; text-align: center; display: flex; flex-direction: column;">
    @if ($model->images->isNotEmpty())
        @php
            $defaultImage = $model->images->firstWhere('is_default', true);
        @endphp
        @if ($defaultImage)
            <img src="{{ Storage::url('images/' . $model->category->category_name . '/' . $model->brand->brand_name . '/' . $defaultImage->filename) }}" alt="{{ $model->title }}" style="height: auto; width: 100%; object-fit: contain; margin: 5px 0 0 0;" />
        @else
            <img src="{{ asset('images/no-img.jpg') }}" alt="Default Image" style="height: auto; width: 100%; object-fit: contain; margin: 5px 0 0 0;" />
        @endif
    @else
        <img src="{{ asset('images/no-img.jpg') }}" alt="no-image" style="height: auto; width: 100%; object-fit: contain;" class="card-img-top" />
    @endif

    <div class="card-body" style="flex-grow: 1; margin-bottom: 10px;">
        <h5 class="card-title">{{ $model->brand->brand_name }} {{ $model->title }}</h5>
    </div>

    <div class="price-cart-container" style="margin-top: auto;">
        <p class="card-text">{{ $model->price }} &#8372;</p>

        <form action="{{ route('cart.add', ['id' => $model->id]) }}" method="POST" style="display: inline;">
            @csrf
            <input type="hidden" name="returnUrl" value="{{ request()->fullUrl() }}">
            <button type="submit" class="btn btn-outline-primary" title="Add to Cart">
                <svg style="width: 100%; height: 100%;" width="40" height="30" fill="currentColor" class="bi bi-cart" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M11 7h1a.5.5 0 1 1 0 1h-1v1a.5.5 0 1 1-1 0V8H9a.5.5 0 0 1 0-1h1V6a.5.5 0 1 1 1 0v1zM5.323 4H8a.5.5 0 0 1 0 1H5.532l1.25 6h7.314l1.286-6H13a.5.5 0 1 1 0-1h3a.5.5 0 0 1 .489.605l-1.5 7A.5.5 0 0 1 14.5 12H6.99l.417 2H14a2 2 0 1 1-1.733 1H8.733a2 2 0 1 1-2.329-.91L4.094 3H2.5a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .49.398L5.322 4zM8 16a1 1 0 1 0-1.999-.001A1 1 0 0 0 8 16zm7 0a1 1 0 1 0-1.999-.001A1 1 0 0 0 15 16z"></path>
                </svg>
            </button>
        </form>
    </div>
</div>
