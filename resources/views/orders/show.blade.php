@extends('layouts.myLayout')

@section('content')
    <div class="container">
{{--        @dd($order);--}}
        <h1>Деталі замовлення #{{ $order->id }}</h1>
        <p>Статус: {{ $order->status_name }}</p>
        <p>Коментар: {{ $order->comment }}</p>

        <h4>Продукти</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Продукт</th>
                <th>Кількість</th>
                <th>Ціна</th>
                <th>Сума</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->orderProducts as $orderProduct)
                <tr>
                    <td>{{ $orderProduct->product->title }}</td>
                    <td>{{ $orderProduct->quantity }}</td>
                    <td>{{ $orderProduct->price }} &#8372;</td>
                    <td>{{ $orderProduct->price * $orderProduct->quantity}} &#8372;</td>
                </tr>
            @endforeach

            <td></td>
            <td></td>
            <td>Всього:</td>
            <td>{{$order->total_amount}} &#8372;</td>
            </tbody>
        </table>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Назад до замовлень</a>
    </div>
@endsection
