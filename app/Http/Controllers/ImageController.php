<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\AddImagesRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    private $context;

    public function __construct()
    {
        $this->context = DB::table('images');
    }

    // Виведення всіх зображень із можливістю фільтрування за категорією
    public function index(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $imagesQuery = Image::with(['product', 'product.brand']);

        if ($categoryId) {
            $imagesQuery->whereHas('product', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        $images = $imagesQuery->get();

        return view('images.index', compact('images'));
    }

    // Виведення форми для додавання нового зображення
    public function create()
    {
        $categories = Category::has('products')->distinct()->get();

        return view('images.create', [
            'categories' => $categories,
        ]);
    }

    // Редагування зображення
    public function edit($id)
    {
        $image = Image::findOrFail($id);

        return view('images.edit', compact('image'));
    }

    // Оновлення зображення
    public function update(Request $request, $id)
    {
        $image = Image::findOrFail($id);

        if ($request->hasFile('newImage')) {
            $newImage = $request->file('newImage');
            $imageData = file_get_contents($newImage->getRealPath());
            $image->image_data = $imageData;
            $image->save();

            return redirect()->route('images.index')->with('success', 'Image updated successfully.');
        }

        return back()->with('error', 'No image selected.');
    }

    // Отримання брендів за категорією
    public function getBrandsByCategory($id)
    {
        $brands = Product::where('category_id', $id)
            ->with('brand')
            ->distinct()
            ->get(['brand_id']);

        return response()->json($brands);
    }

    // Отримання продуктів за категорією та брендом
    public function getProducts(Request $request)
    {
        $products = Product::where('brand_id', $request->brand_id)
            ->where('category_id', $request->category_id)
            ->get();

        return response()->json($products);
    }

    // Додавання зображення
    public function store(AddImagesRequest $request)
    {
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $imageData = file_get_contents($photo->getRealPath());

                Image::create([
                    'image_data' => $imageData,
                    'product_id' => $request->product_id,
                ]);
            }
        }

        return redirect()->route('images.index')->with('success', 'Images added successfully.');
    }

    // Встановлення зображення за замовчуванням
    public function setDefault($id)
    {
        $image = Image::with('product')->findOrFail($id);
        $productId = $image->product_id;

        // Скидання всіх зображень продукту
        Image::where('product_id', $productId)->update(['is_default' => false]);

        // Встановлення цього зображення як основного
        $image->is_default = true;
        $image->save();

        return redirect()->route('images.index')->with('success', 'Default image set successfully.');
    }
}
