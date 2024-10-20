@extends('layouts.myLayout')

@section('content')
    <div class="container">
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
                    <td>{{ $orderProduct->price * $orderProduct->quantity }} &#8372;</td>
                </tr>
            @endforeach

            <tr>
                <td></td>
                <td></td>
                <td>Всього:</td>
                <td>{{ $order->total_amount }} &#8372;</td>
            </tr>
            </tbody>
        </table>

        <!-- Додаємо перевірку на статус PAID і залогованого користувача -->
        @if($order->status === \App\Models\OrderStatus::NOTPAIDED && $order->user_id === auth()->user()->id)
            <form action="{{ route('orders.pay', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Оплатити замовлення</button>
            </form>
        @endif

        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Manager'))

        <h4>Змінити статус замовлення</h4>
            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="status">Виберіть новий статус:</label>
                    <select name="status" id="status" class="form-control">
                        @if($order->status == \App\Models\OrderStatus::NOTPAIDED)
                            <!-- Якщо статус "Очікується оплата", то показуємо тільки варіант "Скасовано" -->
                            <option value="{{ \App\Models\OrderStatus::NOTPAIDED }}" {{ $order->status == \App\Models\OrderStatus::NOTPAIDED ? 'selected' : '' }}>
                                Очікується оплата
                            </option>
                            <option value="{{ \App\Models\OrderStatus::CANCELED }}" {{ $order->status == \App\Models\OrderStatus::CANCELED ? 'selected' : '' }}>
                                Скасовано
                            </option>
                        @else
                            <!-- Якщо інший статус, показуємо всі доступні -->
                            @foreach(\App\Models\OrderStatus::statusLabels() as $status => $label)
                                <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Змінити статус</button>
            </form>
        @endif

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Назад до замовлень</a>
    </div>
@endsection
