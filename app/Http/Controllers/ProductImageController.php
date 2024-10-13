<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImageController extends Controller
{
    // Виведення всіх зображень продукту із фільтром за категорією
    public function index(Request $request)
    {

        $categoryId = $request->input('category_id');
        $brandId = $request->input('brand_id');
        $imagesQuery = ProductImage::with('product');

        // Фільтрація за категорією
        if ($categoryId) {
            $imagesQuery->whereHas('product', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        // Фільтрація за брендом
        if ($brandId) {
            $imagesQuery->whereHas('product', function ($query) use ($brandId) {
                $query->where('brand_id', $brandId);
            });
        }

        $images = $imagesQuery->get();
        $products = Product::with('images', 'category', 'brand')->get();
        return view('product_images.index', compact('products'));
//        return view('product_images.index', compact('images'));
    }

    // Виведення форми для додавання нового зображення продукту
    public function create()
    {
        $products = Product::all();
        $brands = Brand::all();
        $categories = Category::all();

        return view('product_images.create', compact('products', 'brands', 'categories'));
    }

    public function edit($id)
    {
        $image = ProductImage::findOrFail($id); // Знайти зображення за ID

        return view('product_images.edit', compact('image')); // Повертаємо у вигляд редагування
    }

    // Збереження нового зображення
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'photos.*' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ]);

        $product = Product::with(['category', 'brand'])->findOrFail($request->product_id);
        $categoryFolder = 'images/' . $product->category->category_name; // Шлях до папки категорії
        $brandFolder = $product->brand ? $product->brand->brand_name : 'no-brand'; // Шлях до папки бренду

        foreach ($request->file('photos') as $image) {
            $filename = $image->hashName();

            // Створення шляху до зображення
            $path = $categoryFolder . '/' . $brandFolder;

            // Створення папок, якщо вони не існують
            Storage::disk('public')->makeDirectory($path);

            // Збереження зображення у вказаному шляху
            $image->storeAs($path, $filename, 'public');

            ProductImage::create([
                'original_filename' => $image->getClientOriginalName(),
                'filename' => $filename,
                'disk' => 'public',
                'is_default' => $request->has('is_default') ? true : false,
                'product_id' => $request->product_id,
            ]);
        }

        return redirect()->route('product_images.index')->with('success', 'Images uploaded successfully.');
    }

    // Оновлення зображення
    public function update(Request $request, $id)
    {
        // Валідація
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        // Знайти зображення за ID
        $image = ProductImage::findOrFail($id);

        // Шлях до старого зображення
        $oldImagePath = 'images/' . $image->product->category->category_name . '/' . $image->product->brand->brand_name . '/' . $image->filename;

        // Видалення старого зображення, якщо воно є
        if ($image->filename && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        // Отримуємо нове зображення
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Зберігаємо нову назву файлу
            $originalName = $file->getClientOriginalName(); // Оригінальна назва файлу
            $hashedName = $file->hashName();

            // Шлях до нового зображення
            $path = 'images/' . $image->product->category->category_name . '/' . $image->product->brand->brand_name . '/' . $hashedName;

            // Завантаження нового зображення на публічний диск
            Storage::disk('public')->put($path, file_get_contents($file));

            // Оновлення запису у базі даних
            $image->filename = $hashedName; // Хешована назва
            $image->original_filename = $originalName; // Оригінальна назва
        }

        // Зберігаємо зміни
        $image->save();

        return redirect()->route('product_images.index')->with('success', 'Image updated successfully.');
    }



    // Встановлення зображення за замовчуванням
    public function setDefault($id)
    {
        $image = ProductImage::with('product')->findOrFail($id);
        $productId = $image->product_id;

        // Скидання всіх зображень продукту
        ProductImage::where('product_id', $productId)->update(['is_default' => false]);

        // Встановлення цього зображення як основного
        $image->update(['is_default' => true]);

        return redirect()->route('product_images.index')->with('success', 'Default image set successfully.');
    }

    // Видалення зображення
    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        // Видалення файлу з диска, якщо це не 'no-image.jpg'
        if ($image->filename !== 'no-image.jpg') {
            Storage::disk($image->disk)->delete($image->getFullFilename());
        }

        // Видалення з бази даних
        $image->delete();

        return redirect()->route('product_images.index')->with('success', 'Image deleted successfully.');
    }

    // Видалення всіх зображень продукту при його видаленні
    public function deleteProductImages(Product $product)
    {
        // Отримання всіх зображень продукту
        $images = ProductImage::where('product_id', $product->id)->get();

        foreach ($images as $image) {
            // Видалення всіх зображень, окрім 'no-image.jpg'
            if ($image->filename !== 'no-image.jpg') {
                Storage::disk($image->disk)->delete($image->getFullFilename());
            }
        }

        // Видалення записів з бази даних
        ProductImage::where('product_id', $product->id)->delete();
    }

    // Отримання брендів по категорії
    public function getBrandsByCategory($categoryId)
    {
        try {
            // Отримуємо унікальні бренди продуктів для вибраної категорії
            $brands = Brand::whereHas('products', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->distinct()->get();
            // Повертаємо частковий вигляд для селектора брендів
            return view('profile.partials.brands', compact('brands'))->render();
        } catch (\Exception $e) {
            \Log::error('Error fetching brands: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }



    public function getProducts(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $brandId = $request->input('brandId');

        try {
            $products = Product::where('category_id', $categoryId)
                ->where('brand_id', $brandId)
                ->get();

            return view('profile.partials.products', compact('products'))->render();
        } catch (\Exception $e) {
            \Log::error('Error fetching products: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}
