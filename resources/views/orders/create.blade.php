@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Оформлення замовлення</h1>

        @if (session('cart') && count(session('cart')) > 0)
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                @if($isAddressIncomplete)
                    <!-- Якщо адреса не повна, показуємо форму для заповнення -->
                    <h3>Введіть адресу доставки</h3>
                    <div class="form-group">
                        <label for="phone">Телефон *</label>
                        <input type="text" class="form-control" id="phone" name="phone" required value="{{ old('phone', $info->phone ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="address_line1">Адреса (лінія 1) *</label>
                        <input type="text" class="form-control" id="address_line1" name="address_line1" required value="{{ old('address_line1', $info->address_line1 ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="address_line2">Адреса (лінія 2)</label>
                        <input type="text" class="form-control" id="address_line2" name="address_line2" value="{{ old('address_line2', $info->address_line2 ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="city">Місто *</label>
                        <input type="text" class="form-control" id="city" name="city" required value="{{ old('city', $info->city ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Поштовий код *</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code" required value="{{ old('postal_code', $info->postal_code ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="country">Країна *</label>
                        <input type="text" class="form-control" id="country" name="country" required value="{{ old('country', $info->country ?? '') }}">
                    </div>
                @else
                    <!-- Якщо адреса є, показуємо її -->
                    <h3>Адреса доставки</h3>
                    <p>{{ $info->address_line1 }} {{ $info->address_line2 ? ', ' . $info->address_line2 : '' }}, {{ $info->city }}, {{ $info->postal_code }}, {{ $info->country }}</p>

                    <!-- Кнопка для зміни адреси -->
                    <button type="button" class="btn btn-link" id="changeAddressBtn">Змінити адресу</button>

                    <!-- При натисканні на кнопку показується форма -->
                    <div id="changeAddressForm" style="display: none;">
                        <h3>Змініть адресу доставки</h3>
                        <div class="form-group">
                            <label for="phone">Телефон *</label>
                            <input type="text" class="form-control" id="phone" name="phone" required value="{{ old('phone', $info->phone ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="address_line1">Адреса (лінія 1) *</label>
                            <input type="text" class="form-control" id="address_line1" name="address_line1" required value="{{ old('address_line1', $info->address_line1 ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="address_line2">Адреса (лінія 2)</label>
                            <input type="text" class="form-control" id="address_line2" name="address_line2" value="{{ old('address_line2', $info->address_line2 ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="city">Місто *</label>
                            <input type="text" class="form-control" id="city" name="city" required value="{{ old('city', $info->city ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="postal_code">Поштовий код *</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" required value="{{ old('postal_code', $info->postal_code ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="country">Країна *</label>
                            <input type="text" class="form-control" id="country" name="country" required value="{{ old('country', $info->country ?? '') }}">
                        </div>
                    </div>
                @endif

                <!-- Метод доставки -->
                <h3>Метод доставки</h3>
                <select name="delivery_method" class="form-control" required>
                    <option value="nova_poshta">Нова Пошта</option>
                    <option value="ukrposhta">Укрпошта</option>
                </select>

                <!-- Метод оплати -->
                <h3>Метод оплати</h3>
                <select name="payment_method" class="form-control" required>
                    <option value="liqpay">LiqPay</option>
                    <option value="cash_on_delivery">Готівка при отриманні</option>
                </select>

                <div class="form-group">
                    <label for="comment">Коментар до замовлення:</label>
                    <textarea name="comment" class="form-control" id="comment" rows="4"></textarea>
                </div>

                <h3>Ваш кошик</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Назва товару</th>
                        <th>Кількість</th>
                        <th>Ціна</th>
                        <th>Сумарна ціна</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $totalPrice = session()->get('totalPrice'); ?>
{{--                    @dd($totalPrice);--}}

                    @foreach (session('cart') as $item)
                        <tr>
                            <td>{{ $item['title'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['price'] }} &#8372;</td>
                            <td>{{ $item['price'] * $item['quantity'] }} &#8372;</td>
                        </tr>
                    @endforeach
                    <td></td>
                    <td></td>
                    <td>Всього</td>
                    <td>{{$totalPrice}} &#8372;</td>

                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary mt-3">Оформити замовлення</button>
            </form>
        @else
            <p>Ваш кошик порожній.</p>
        @endif
    </div>
@endsection

@section('end_script')
    <script>
        document.getElementById('changeAddressBtn').addEventListener('click', function () {
            document.getElementById('changeAddressForm').style.display = 'block';
        });
    </script>
@endsection
