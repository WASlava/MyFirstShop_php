@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Ваш кошик</h1>

        @if(count($cart) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Фото</th>
                    <th>Назва товару</th>
                    <th>Ціна за одиницю, &#8372;</th>
                    <th>Кількість</th>
                    <th>Сума &#8372;</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($cart as $id => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" style="height:100px;"/></td>
                        <td>{{ $item['title'] }}</td>
                        <td>{{ $item['price'] }} &#8372;</td>
                        <td class="item-count" data-row-id="{{ $id }}">
                            <div class="d-flex text-center">
                                <span class="flex-fill rounded-start border p-2" onclick="decCount(event, {{ $id }})">-</span>
                                <span class="flex-fill border p-2">{{ $item['quantity'] }}</span>
                                <span class="flex-fill rounded-end border p-2" onclick="incCount(event, {{ $id }})">+</span>
                            </div>
                        </td>
                        <td>{{ $item['price'] * $item['quantity'] }} &#8372;</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-dark">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5"></td>
                    <td id="total-Price">{{ $totalPrice }} &#8372;</td>
                </tr>
                </tbody>
            </table>
            <form method="get" action="{{ route('cart.clear') }}">
                @csrf
                <button type="submit" class="btn btn-warning">Очистити кошик</button>
            </form>
            <form method="get" action="{{ route('orders.create') }}">
                <button type="submit" class="btn btn-primary">Оформити замовлення</button>
            </form>
        @else
            <p>Ваш кошик порожній.</p>
        @endif
    </div>
@endsection

@section('end_scripts')
    <script type="text/javascript">
        async function incCount(e, productId) {
            let resp = await fetch(`/cart/IncCount/${productId}`, {
                method: 'post',
                headers: {
                    accept: 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            if (resp.ok) {
                let info = await resp.json();
                e.target.previousElementSibling.innerText = info.count;
                e.target.parentElement.parentElement.nextElementSibling.innerText = info.totalPrice;
                await getTotalPrice();
                await updateCartSummary();
            }
        }

        async function decCount(e, productId) {
            let resp = await fetch(`/cart/decCount/${productId}`, {
                method: 'post',
                headers: {
                    accept: 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            if (resp.ok) {
                let info = await resp.json();
                let currentRow = e.target.closest('tr');
                if (info.count == 0) {
                    currentRow.remove();
                } else {
                    e.target.nextElementSibling.innerText = info.count;
                    e.target.parentElement.parentElement.nextElementSibling.innerText = info.totalPrice;
                }
                await getTotalPrice();
                await updateCartSummary();
            }
        }

        async function getTotalPrice() {
            let resp = await fetch(`/cart/getTotalPrice`, {
                method: 'get',
                headers: {
                    accept: 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            if (resp.ok) {
                let info = await resp.json();
                document.getElementById('total-Price').innerText = info.totalPrice;
            }
        }

        async function updateCartSummary() {
            let response = await fetch(`/cart/summary`, {
                method: 'get',
                headers: {
                    accept: 'application/json'
                }
            });

            if (response.ok) {
                let summary = await response.json();

                document.getElementById('cart-total-items').innerText = summary.totalItems;
                document.getElementById('cart-total-price').innerText = summary.totalPrice + ' ₴';
                document.getElementById('total-Price').innerText = summary.totalPrice + ' ₴';
            }
        }

    </script>
@endsection
