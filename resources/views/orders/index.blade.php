@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Ваші замовлення</h1>

        @if ($orders->count() > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Дата створення</th>
                    <th>Вартість</th>
                    <th>Статус</th>
                    <th>Коментар</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->total_amount }} &#8372;</td>
                        <td>{{ $order->status_name }}</td>
                        <td>{{ $order->comment }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">Переглянути</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Ви ще не маєте замовлень.</p>
        @endif
    </div>
@endsection
