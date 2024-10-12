@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Оформлення замовлення</h1>

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <!-- Додайте поля для інформації про клієнта та замовлення -->
            <div class="form-group">
                <label for="name">Ваше ім'я:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Електронна пошта:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="address">Адреса доставки:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>

            <button type="submit" class="btn btn-primary">Підтвердити замовлення</button>
        </form>
    </div>
@endsection
