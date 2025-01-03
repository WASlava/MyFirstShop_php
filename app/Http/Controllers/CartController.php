<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    // Відображення кошика
    public function index()
    {
        $cart = session()->get('cart', []); // Отримуємо кошик із сесії

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        session()->put('totalPrice', $totalPrice);
        return view('cart.index', compact('cart', 'totalPrice'));
    }

    // Додавання товару до кошика
    public function addToCart(Request $request, $id)
    {
        $product = Product::with(['category', 'brand', 'images'])->findOrFail($id);

        // Отримуємо назву бренду або задаємо значення за замовчуванням
        $brandName = $product->brand ? $product->brand->brand_name : 'Unknown Brand';
        $categoryName = $product->category ? $product->category->category_name : 'Unknown Brand';
        $defaultImage = $product->images->where('is_default', 1)->first();

        $cart = session()->get('cart', []);

        // Перевірка, чи є товар уже в кошику
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $imageUrl = $product->images->first()
                ? Storage::url('images/' . $categoryName . '/' . $brandName . '/' . $defaultImage->filename)
                : Storage::url('images/default.jpg');

            // Додаємо товар у кошик, якщо його немає
            $cart[$id] = [
                "id" => $product->id,
                "title" => $product->title,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $imageUrl,
                "brand" => $brandName,
                "category" => $categoryName,
            ];
        }

        session()->put('cart', $cart); // Зберігаємо кошик у сесії
        return back()->with('success', 'Product added to cart!');
//        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Оновлення кількості товару
    public function updateCart(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']); // Валідація кількості

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
        }

        return redirect()->route('cart.index')->with('error', 'Product not found in cart!');
    }

    // Видалення товару з кошика
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
        }

        return redirect()->route('cart.index')->with('error', 'Product not found in cart!');
    }

    // Очищення кошика
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }

    // Збільшення кількості товару
    public function increaseQuantity($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            $totalPrice = $cart[$id]['price'] * $cart[$id]['quantity'];

            $this->updateTotalPriceInSession($cart);

            return response()->json([
                'count' => $cart[$id]['quantity'],
                'totalPrice' => $totalPrice
            ]);
        }
        return response()->json(['error' => 'Product not found'], 404);
    }

    // Зменшення кількості товару
    public function decreaseQuantity($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']--;
            if ($cart[$id]['quantity'] <= 0) {
                unset($cart[$id]); // Видаляємо товар, якщо його кількість стала 0
            }
            session()->put('cart', $cart);

            // Оновлюємо загальну вартість замовлення в сесії
            $this->updateTotalPriceInSession($cart);

            $totalPrice= isset($cart[$id]) ? $cart[$id]['price'] * $cart[$id]['quantity'] : 0;

            return response()->json([
                'count' => isset($cart[$id]) ? $cart[$id]['quantity'] : 0,
                'totalPrice' => $totalPrice
            ]);
        }
        return response()->json(['error' => 'Product not found'], 404);
    }

    public function getTotalPrice()
    {
        $cart = session()->get('cart', []);
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json(['totalPrice' => $totalPrice]);
    }

    private function updateTotalPriceInSession($cart): void
    {
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Записуємо загальну вартість у сесію
        session()->put('totalPrice', $totalPrice);
    }


    public function getCartSummary()
    {
        $cart = session()->get('cart', []);
        $totalItems = 0;
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
            $totalPrice += $item['price'] * $item['quantity'];
        }
        session()->put('totalPrice', $totalPrice);
        return response()->json([
            'totalItems' => $totalItems,
            'totalPrice' => $totalPrice
        ]);
    }
}
