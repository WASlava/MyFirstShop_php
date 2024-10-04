<?php

use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;





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
Route::get('/users', [HomeController::class, 'index'])->name('users.index');
Route::get('/image', [HomeController::class, 'index'])->name('image.index');
//Route::get('/brands', [HomeController::class, 'index'])->name('brands.index');
Route::get('/claims', [HomeController::class, 'index'])->name('claims.index');
Route::resource('categories', CategoryController::class);
Route::resource('brands', BrandsController::class);

//Route::get('/', [MyInfoController::class, 'index'])->name('home');
//Route::get('/Products', [MyInfoController::class, 'about'])->name('product');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
