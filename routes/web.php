<?php

use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;




//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', function () {
    return view('components.navigation');
});



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/error', [HomeController::class, 'error'])->name('error');
Route::get('/account', [HomeController::class, 'index'])->name('account.index');
Route::get('/roles', [HomeController::class, 'index'])->name('roles.index');
Route::get('/image', [HomeController::class, 'index'])->name('image.index');
Route::resource('categories', CategoryController::class);
Route::resource('brands', BrandsController::class);
Route::resource('users', UsersController::class);
Route::resource('roles', RoleController::class);
Route::resource('products', ProductsController::class);
Route::resource('image', ProductImageController::class);
Route::resource('product_images', ProductImageController::class);
//Route::resource('cart', CartController::class);
Route::post('product_images/{id}/set_default', [ProductImageController::class, 'setDefault'])->name('product_images.set_default');
Route::post('/product_images/getBrandsByCategory/{category}', [ProductImageController::class, 'getBrandsByCategory']);
//Route::middleware(['auth'])->group(function () {
//    Route::resource('orders', OrderController::class);
//});
Route::post('/cart/IncCount/{id}', [CartController::class, 'increaseQuantity'])->name('cart.increase');
Route::post('/cart/decCount/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
Route::get('/cart/summary', [CartController::class, 'getCartSummary'])->name('cart.summary');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{id}/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/{id}/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/{id}/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/cart/getTotalPrice', [CartController::class, 'getTotalPrice'])->name('cart.getTotalPrice');
//Route::get('/cart', [CartController2::class, 'index'])->name('cart.index');
Route::patch('/products/{id}', [ProductsController::class, 'update'])->name('products.update');
//Route::get('cart', [CartController::class, 'index'])->name('cart.index');
//Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
//Route::delete('cart/remove/{id}', [CartController2::class, 'remove'])->name('cart.remove');
//Route::get('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
//Route::post('/cart/addToCart/{id}', [CartController2::class, 'addToCart'])->name('cart.addToCart');
//Route::resource('account', AccountController::class);
Route::get('/users/{id}/change-password', [UsersController::class, 'changePassword'])->name('users.changePassword');
Route::post('/users/{id}/update-password', [UsersController::class, 'updatePassword'])->name('users.updatePassword');
Route::get('users/{id}/change-role', [RoleController::class, 'changeRole'])->name('users.changeRole');
Route::get('users/{id}', [UsersController::class, 'show'])->name('users.show');
Route::get('/products/show/{id}', [ProductsController::class, 'show'])->name('products.show');
//Route::post('/users/{id}/change-password', [UsersController::class, 'changePassword'])->name('users.changePassword');
//Route::post('users/update-roles', [RoleController::class, 'updateUserRoles'])->name('users.updateRoles');
//Route::get('/', [MyInfoController::class, 'index'])->name('home');
//Route::get('/Products', [MyInfoController::class, 'about'])->name('product');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//    Route::resource('users', UsersController::class);
});

require __DIR__.'/auth.php';
