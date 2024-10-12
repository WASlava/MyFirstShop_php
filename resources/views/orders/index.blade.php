@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Ваші замовлення</h1>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Статус</th>
                <th>Коментар</th>
                <th>Деталі</th>
                <th>Дія</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->comment }}</td>
                    <td><a href="{{ route('orders.show', $order->id) }}">Переглянути</a></td>
                    <td>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Створити нове замовлення</a>
    </div>
@endsection
