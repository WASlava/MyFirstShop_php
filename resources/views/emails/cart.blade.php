<h1>Hello, {{ $user->name }}</h1>
<p>Your order:</p>
<table>
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
    </tr>
    @foreach($cart->items as $item)
        <tr>
            <td>{{ $item['product']->title }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>{{ $item['product']->price }} ₴</td>
            <td>{{ $item['totalPrice'] }} ₴</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3">Total:</td>
        <td>{{ $totalPrice }} ₴</td>
    </tr>
</table>
