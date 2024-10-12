<?php

namespace App\Http\Requests;

use App\Models\Cart;
use Closure;
use Illuminate\Support\Facades\Session;

class CartSessionMiddleware
{
    public function handle($request, Closure $next)
    {
        // Перевіряємо наявність кошика в сесії
        if (!Session::has('cart')) {
            Session::put('cart', new Cart([]));
        }

        return $next($request);
    }
}
