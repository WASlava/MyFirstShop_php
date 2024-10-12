@php
    // Отримання товарів з сесії
    $cartItems = session('cart', []);
    $cartMessage = 'Cart is empty';
    $itemsCount = 0;
    $totalPrice = 0.0;

    if (!empty($cartItems)) {
        foreach ($cartItems as $item) {
            $itemsCount += $item['quantity'];
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $cartMessage = "{$itemsCount} items, total price: {$totalPrice} &#8372;";
    }
@endphp

<div class="cart-container d-flex align-items-center position-relative">
    <form action="{{ route('cart.index') }}" method="GET" class="d-flex align-items-center">
        @csrf
        <input type="hidden" name="returnUrl" value="{{ request()->fullUrl() }}">
        <button type="submit" class="btn btn-outline-secondary position-relative cart-button">
            <i class="fas fa-shopping-cart fa-2x"></i>
            @if ($itemsCount > 0)
                <span id="cart-total-items" class="cart-count badge rounded-pill bg-danger position-absolute">{{ $itemsCount }}</span>
                <span id="cart-total-price" class="total-price position-absolute">{{ $totalPrice }} &#8372;</span>
            @endif
        </button>
    </form>
</div>
