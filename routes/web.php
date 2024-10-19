<?php

use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;



Route::get('/', function () {
    return view('components.navigation');
});

Route::middleware(['auth', 'Admin'])->group(function () {
    Route::resource('roles', RoleController::class);
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/error', [HomeController::class, 'error'])->name('error');
Route::get('/roles', [HomeController::class, 'index'])->name('roles.index');
Route::get('/image', [HomeController::class, 'index'])->name('image.index');
Route::get('/payment/{order_id}', [PaymentController::class, 'show'])->name('payment');
Route::post('/payment/{order_id}', [PaymentController::class, 'process'])->name('payment.process');

Route::middleware(['auth', 'verified'])->group(function () {
//    Route::resource('account', ProfileController::class);
    Route::get('/account', [ProfileController::class, 'index'])->name('account.index');
    Route::get('/account/{account}/edit', [ProfileController::class, 'editInf'])->name('profile.editInf');
    Route::get('/account/editInf', [ProfileController::class, 'editInf'])->name('profile.editInf');
    Route::post('/account/updateInf', [ProfileController::class, 'updateInf'])->name('profile.updateInf');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/users/{user}', [OrderController::class, 'getUserOrders'])->name('orders.users');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/users/{id}', [OrderController::class, 'users'])->name('orders.users');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
});

Route::resource('products', ProductsController::class);
Route::patch('/products/{id}', [ProductsController::class, 'update'])->name('products.update');
Route::get('/products/show/{id}', [ProductsController::class, 'show'])->name('products.show');

Route::middleware(['auth'])->group(function () {
Route::resource('categories', CategoryController::class);


Route::resource('brands', BrandsController::class);


Route::resource('users', UsersController::class);
Route::get('users/{id}', [UsersController::class, 'show'])->name('users.show');
Route::get('/users/{id}/change-password', [UsersController::class, 'changePassword'])->name('users.changePassword');
Route::get('/users/{id}/change-role', [UsersController::class, 'changeRole'])->name('users.changeRole');
Route::post('/users/{id}/role', [UsersController::class, 'updateRole'])->name('users.updateRole');
Route::put('/users/{id}/password', [UsersController::class, 'updatePassword'])->name('users.updatePassword');


Route::resource('roles', RoleController::class);




Route::resource('image', ProductImageController::class);
Route::resource('product_images', ProductImageController::class);
Route::post('product_images/getBrandsByCategory/{categoryId}', [ProductImageController::class, 'getBrandsByCategory'])->name('product_images.getBrandsByCategory');
Route::post('product_images/getProducts', [ProductImageController::class, 'getProducts']);
Route::get('/product_images/{id}/edit', [ProductImageController::class, 'edit'])->name('product_images.edit');
Route::post('product_images/{id}/set_default', [ProductImageController::class, 'setDefault'])->name('product_images.set_default');


Route::post('/cart/IncCount/{id}', [CartController::class, 'increaseQuantity'])->name('cart.increase');
Route::post('/cart/decCount/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
Route::get('/cart/summary', [CartController::class, 'getCartSummary'])->name('cart.summary');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{id}/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/{id}/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/{id}/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::post('/cart/getTotalPrice', [CartController::class, 'getTotalPrice'])->name('cart.getTotalPrice');


});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';
