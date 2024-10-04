<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Додаємо кошик у всі подання
        view()->composer('*', function ($view) {
            $cart = Session::get('cart', new Cart([]));
            $view->with('cart', $cart);
        });
    }
}
