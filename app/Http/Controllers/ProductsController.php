<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    // Виведення списку продуктів
    public function index(Request $request)
    {
        $categoryId = $request->input('categoryId');

        // Отримуємо продукти з категорією, брендом та зображеннями
        $products = Product::with(['category', 'brand', 'images']);

        if ($categoryId) {
            $products->where('category_id', $categoryId);
        }

        return view('products.index', ['products' => $products->get()]);
    }

    // Виведення деталей продукту
    public function show($id)
    {
        $product = Product::with(['category', 'brand', 'images'])->findOrFail($id);

        return view('products.show', compact('product'));
    }

    // Виведення форми для створення нового продукту
    public function create()
    {
        $brands = Brand::all();;
        $categories = Category::all();

        return view('products.create', compact('brands', 'categories'));
    }

    // Обробка POST-запиту для створення продукту
//    public function store(StoreProductRequest $request)
//    {
        public function store(Request $request)
    {
        // Валідація
        $validatedData = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'is_favorite' => 'boolean',
        ]);

        // Створення продукту
        $product = new Product();
        $product->title = $validatedData['title'];
        $product->price = $validatedData['price'];
        $product->description = $validatedData['description'] ?? '';
        $product->brand_id = $validatedData['brand_id'];
        $product->category_id = $validatedData['category_id'];
        $product->is_favorite = $request->has('is_favorite') ? 1 : 0;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }


    // Виведення форми для редагування продукту
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::all();
        $categories = Category::all();
//        $brands = Brand::pluck('brand_name', 'id');
//        $categories = Category::pluck('category_name', 'id');

        return view('products.edit', compact('product', 'brands', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Валідація даних
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'is_favorite' => 'boolean',
        ]);

        // Знайти продукт за ID
        $product = Product::findOrFail($id);

        // Оновити продукт з валідованими даними
        $product->title = $validated['title'];
        $product->price = $validated['price'];
        $product->description = $validated['description'] ?? '';
        $product->brand_id = $validated['brand_id'];  // Оновлення бренду
        $product->category_id = $validated['category_id'];  // Оновлення категорії
        $product->is_favorite = $request->has('is_favorite') ? 1 : 0;

        $product->save();
        // Перенаправлення на сторінку списку продуктів з повідомленням про успішне оновлення
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    // Видалення продукту
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        app(ProductImageController::class)->deleteProductImages($product);

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
