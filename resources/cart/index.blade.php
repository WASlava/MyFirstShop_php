@extends('layouts.myLayout')

@section('content')
    <h1>Shopping Cart</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (empty($cart))
        <p>Your cart is empty</p>
    @else
        <table class="table">
            <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($cart as $id => $item)
                <tr>
                    <td><img src="{{ $item['image'] }}" width="50" height="50"></td> <!-- Відображення зображення -->
                    <td>{{ $item['title'] }} ({{ $item['brand'] }})</td> <!-- Назва товару та бренд -->
                    <td>
                        <form action="{{ route('cart.update', $id) }}" method="post">
                            @csrf
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                    <td>${{ $item['price'] }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <form action="{{ route('cart.clear') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-danger">Clear Cart</button>
        </form>
    @endif
@endsection
