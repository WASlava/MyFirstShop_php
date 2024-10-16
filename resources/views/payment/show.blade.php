@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Оплата замовлення #{{ $order->id }}</h1>

        <p>Сумма: {{ $order->totalAmount }} грн</p>

{{--        {!! $formData['form'] !!}--}}
    </div>
@endsection
