<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Cart;
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
