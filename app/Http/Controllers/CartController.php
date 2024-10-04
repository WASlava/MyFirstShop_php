<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->getCart();
        $returnUrl = $request->input('returnUrl', route('home'));

        return view('cart.index', [
            'cartItems' => $cart->getCartItems(),
            'totalPrice' => $cart->getTotalPrice(),
            'returnUrl' => $returnUrl
        ]);
    }

    public function setCountry()
    {
        session(['country' => 'Ukraine']);
        return view('cart.setCountry');
    }

    public function getCountry()
    {
        $country = session('country', 'Session key country was not set!');
        return view('cart.getCountry', ['country' => $country]);
    }

    public function getCart()
    {
        $cartItems = session('cart', []);
        return new Cart($cartItems);
    }

    public function setCart(Cart $cart)
    {
        session(['cart' => $cart->getCartItems()]);
    }

    public function addToCart($id, Request $request)
    {
        $cart = $this->getCart();
        $product = Product::find($id);

        if (!$product) {
            return abort(404);
        }

        $cart->addToCart(new CartItem(['product' => $product, 'count' => 1]));
        $this->setCart($cart);

        return redirect($request->input('returnUrl', route('home')));
    }

    public function incCount($id)
    {
        $cart = $this->getCart();
        $cart->incCount($id);
        $this->setCart($cart);

        return response()->json([
            'count' => $cart->getItemCount($id),
            'totalPrice' => $cart->getTotalPrice()
        ]);
    }

    public function decCount($id)
    {
        $cart = $this->getCart();
        $cart->decCount($id);
        $this->setCart($cart);

        return response()->json([
            'count' => $cart->getItemCount($id),
            'totalPrice' => $cart->getTotalPrice()
        ]);
    }

    public function removeFromCart($id, Request $request)
    {
        $cart = $this->getCart();
        $cart->removeFromCart($id);
        $this->setCart($cart);

        return redirect()->route('cart.index', ['returnUrl' => $request->input('returnUrl', route('home'))]);
    }

    public function getTotalPrice()
    {
        $cart = $this->getCart();
        return response()->json(['totalPrice' => $cart->getTotalPrice()]);
    }

    public function buy(Request $request)
    {
        $cart = $this->getCart();
        if ($cart->getCartItems()) {
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            $user = Auth::user();
            $total = $cart->getTotalPrice();
            $orderDetails = view('emails.order', compact('cart', 'user', 'total'))->render();

            Mail::send([], [], function ($message) use ($user, $orderDetails) {
                $message->to($user->email)
                    ->subject('Order Confirmation')
                    ->setBody($orderDetails, 'text/html');
            });

            // Clear the cart after order
            session()->forget('cart');
        }

        return redirect()->route('products.index');
    }
}
