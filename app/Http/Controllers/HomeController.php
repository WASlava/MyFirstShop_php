<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    // Виведення головної сторінки з товарами
    public function index(Request $request)
    {
        // Витягуємо параметр категорії з запиту
        $categoryId = $request->query('categoryId');

        // Отримуємо товари з категоріями, брендами та зображеннями
        $products = Product::with(['category', 'brand', 'images']);

        // Якщо категорія передана, фільтруємо товари за нею
        if (!is_null($categoryId)) {
            $products = $products->where('category_id', $categoryId);
        }

        // Передаємо список товарів у вигляд
        return view('home.index', [
            'products' => $products->get(),
        ]);
    }

    // Сторінка конфіденційності
    public function privacy()
    {
        return view('home.privacy');
    }

    // Виведення помилок
    public function error()
    {
        return view('error', [
            'requestId' => request()->server('REQUEST_ID', null)
        ]);
    }
}
