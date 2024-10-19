<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderStatus;

class OrderController extends Controller
{
    public function index()
    {
        // Отримуємо всі замовлення поточного користувача
        $orders = Order::where('user_id', Auth::id())->get();
//        dd($orders);
        return view('orders.index', compact('orders'));
    }

    public function users( Request $request, $id)
    {

//dd($request);
        $userName = User::find($id);;
        $status = $request->get('status');

        $orders = Order::where('user_id', $id);

        if ($status) {
            $orders->where('status', $status);
        }

        $orders = $orders->get();
//dd($orders);
        return view('orders.users',  compact('orders','status', 'id', 'userName'));
    }


    public function create()
    {
        // Отримуємо поточну адресу користувача з таблиці `infos`
        $info = Auth::user()->info;

        // Якщо інформації про користувача немає або адреса неповна, пропонуємо заповнити адресу
        $isAddressIncomplete = !$info || !$info->address_line1 || !$info->city || !$info->postal_code || !$info->country || !$info->phone;

        return view('orders.create', compact('info', 'isAddressIncomplete'));
    }

    public function store(Request $request)
    {
        $products = session()->get('cart', []);
        $user = Auth::user();
        $info = $user->info;

        // Якщо адреса неповна або користувач її змінює, оновлюємо її
        if ($request->filled('address_line1') && $request->filled('city') && $request->filled('postal_code') && $request->filled('country')) {
            $info->phone = $request->input('phone');
            $info->address_line1 = $request->input('address_line1');
            $info->address_line2 = $request->input('address_line2');
            $info->city = $request->input('city');
            $info->postal_code = $request->input('postal_code');
            $info->country = $request->input('country');
            $info->save();
        }

        // Обчислюємо загальну вартість кошика
        $totalAmount = 0;
        foreach ($products as $productData) {
            if (isset($productData['id']) && isset($productData['quantity'])) {
                $product = Product::find($productData['id']);
                if ($product) {
                    $totalAmount += $product->price * $productData['quantity'];
                }
            }
        }

        // Створюємо нове замовлення
        $order = new Order();
        $order->user_id = Auth::id();
        $order->status = OrderStatus::NEW; // статус "Нове"
        $order->comment = $request->input('comment', null); // Дозволяємо пустий коментар
        $order->delivery_method = $request->input('delivery_method'); // Зберігаємо метод доставки
        $order->payment_method = $request->input('payment_method'); // Зберігаємо метод оплати
        $order->address_line1 = $info->address_line1; // Зберігаємо адресу
        $order->address_line2 = $info->address_line2;
        $order->city = $info->city;
        $order->postal_code = $info->postal_code;
        $order->country = $info->country;
        $order->total_amount = $totalAmount; // Зберігаємо загальну ціну замовлення
        $order->save();

        // Додаємо продукти до замовлення
        foreach ($products as $productData) {
            if (isset($productData['id']) && isset($productData['quantity'])) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $productData['id'];
                $orderProduct->quantity = $productData['quantity'];
                $orderProduct->price = Product::find($productData['id'])->price; // Отримуємо ціну продукту
                $orderProduct->save();
            }
        }

        // Очищуємо кошик після оформлення
        session()->forget('cart');

        // Логіка для оплати готівкою
        if ($request->input('payment_method') === 'cash_on_delivery') {
            $order->status = OrderStatus::IN_PROGRESS; // статус "Готується до висилання"
            $order->save();
            return redirect()->route('home')->with('success', 'Замовлення оформлено! Ви обрали оплату готівкою.');
        }

        // Логіка для оплати через LiqPay
        if ($request->input('payment_method') === 'liqpay') {
            $order->status = OrderStatus::NOTPAIDED; // статус "Очікується оплата"
            $order->save();
            return redirect()->route('home')->with('success', 'Замовлення оформлено! Перейдіть до оплати.');
        }

        // Інші методи оплати або за замовчуванням
        return redirect()->route('home')->with('error', 'Метод оплати не підтримується.');
    }



    public function show($id)
    {
        // Показуємо деталі замовлення
        $order = Order::with('orderProducts.product')->findOrFail($id);
//        dd($order);
        return view('orders.show', compact('order', 'id'));
    }

    public function updateStatus(Request $request, $id)
    {
//        if (!auth()->user()->isAdmin() && !auth()->user()->isManager()) {
//            return redirect()->back()->with('error', 'У вас немає доступу для зміни статусу замовлення.');
//        }

        $request->validate([
            'status' => 'required|in:' . implode(',', \App\Models\OrderStatus::getConstants()),
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('orders.users', $order->user_id)->with('success', 'Статус замовлення успішно змінено.');
    }

    public function destroy($id)
    {
        // Видалення замовлення
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Замовлення видалено!');
    }

    public function getUserOrders($userId, Request $request)
    {
        // Знаходимо користувача
        $user = User::findOrFail($userId);

        // Отримуємо фільтрований статус
        $status = $request->input('status');

        // Отримуємо замовлення цього користувача
        $orders = Order::where('user_id', $user->id)
            ->when($status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->get();

        // Повертаємо вигляд з передачею змінних
        return view('orders.users', compact('user', 'orders', 'status'));
    }
}
