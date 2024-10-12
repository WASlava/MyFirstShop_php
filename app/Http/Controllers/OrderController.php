<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Отримуємо всі замовлення поточного користувача
        $orders = Order::where('user_id', Auth::id())->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        // Показуємо форму для створення нового замовлення
        return view('orders.create');
    }

    public function store(Request $request)
    {
        // Створюємо нове замовлення
        $order = new Order();
        $order->user_id = Auth::id();
        $order->status = 0; // статус "нове"
        $order->comment = $request->input('comment');
        $order->save();

        // Додаємо продукти до замовлення
        $products = $request->input('products'); // масив продуктів
        foreach ($products as $productData) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $productData['id'];
            $orderProduct->quantity = $productData['quantity'];
            $orderProduct->price = Product::find($productData['id'])->price; // Отримуємо ціну продукту
            $orderProduct->save();
        }

        return redirect()->route('orders.index')->with('success', 'Замовлення створено!');
    }

    public function show($id)
    {
        // Показуємо деталі замовлення
        $order = Order::with('orderProducts.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function destroy($id)
    {
        // Видалення замовлення
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Замовлення видалено!');
    }
}
