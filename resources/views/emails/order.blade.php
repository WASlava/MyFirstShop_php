<h1>Hello, {{ $user->name }}</h1>
<table>
    <tr><th>Product</th><th>Quantity</th><th>Price</th><th>Sum</th></tr>
    @foreach ($cart->getCartItems() as $item)
        <tr>
            <td>{{ $item->product->title }}</td>
            <td>{{ $item->count }}</td>
            <td>{{ $item->product->price }}</td>
            <td>{{ $item->getTotalPrice() }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3">Total:</td>
        <td>{{ $total }}</td>
    </tr>
</table>
