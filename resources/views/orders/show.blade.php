@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Деталі замовлення #{{ $order->id }}</h1>
        <p>Статус: {{ $order->status }}</p>
        <p>Коментар: {{ $order->comment }}</p>

        <h4>Продукти</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Продукт</th>
                <th>Кількість</th>
                <th>Ціна</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->orderProducts as $orderProduct)
                <tr>
                    <td>{{ $orderProduct->product->title }}</td>
                    <td>{{ $orderProduct->quantity }}</td>
                    <td>{{ $orderProduct->price }} &#8372;</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Назад до замовлень</a>
    </div>
@endsection
