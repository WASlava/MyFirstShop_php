@extends('layouts.myLayout')

@section('content')
    <div class="container">

        <h1>Orders for {{ $user->name }}</h1>

        <form action="{{ route('orders.users', $user->id) }}" method="GET">
            <div class="form-group">
                <label for="status">Фільтр за статусом:</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Всі</option>
                    @foreach(\App\Models\OrderStatus::statusLabels() as $status => $label)
                        <option value="{{ $status }}" {{ $status == request()->input('status') ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Фільтрувати</button>
        </form>

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
