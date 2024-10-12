<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    // Виведення всіх зображень продукту із фільтром за категорією
    public function index(Request $request)
    {
        $categoryId = $request->input('category_id');
        $imagesQuery = ProductImage::with('product');

        if ($categoryId) {
            $imagesQuery->whereHas('product', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        $images = $imagesQuery->get();

        return view('product_images.index', compact('images'));
    }

    // Виведення форми для додавання нового зображення продукту
    public function create()
    {
        $products = Product::all();
        $brands = Brand::all();;
        $categories = Category::all();

//        return view('products.create', compact('brands', 'categories'));

        return view('product_images.create', compact('products', 'brands', 'categories'));
    }

    // Збереження нового зображення
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif',
        ]);

        $product = Product::with('category')->findOrFail($request->product_id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->hashName();

            // Структура папок за категоріями
            $categoryFolder = 'categories/' . $product->category->name;
            $path = $image->storeAs("$categoryFolder/product_images", $filename, 'public');

            ProductImage::create([
                'original_filename' => $image->getClientOriginalName(),
                'filename' => $filename,
                'disk' => 'public',
                'is_default' => false,
                'product_id' => $request->product_id,
            ]);

            return redirect()->route('product_images.index')->with('success', 'Image uploaded successfully.');
        }

        return back()->with('error', 'Failed to upload image.');
    }

    // Оновлення зображення
    public function update(Request $request, $id)
    {
        $image = ProductImage::findOrFail($id);

        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
        ]);

        if ($request->hasFile('image')) {
            // Видалення старого зображення
            Storage::disk($image->disk)->delete($image->getFullFilename());

            // Збереження нового
            $newImage = $request->file('image');
            $filename = $newImage->hashName();
            $categoryFolder = 'categories/' . $image->product->category->name;
            $path = $newImage->storeAs("$categoryFolder/product_images", $filename, $image->disk);

            $image->update([
                'original_filename' => $newImage->getClientOriginalName(),
                'filename' => $filename,
            ]);
        }

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

    public function getBrandsByCategory($categoryId)
    {
        // Отримуємо бренди, що належать до цієї категорії
        $brands = Brand::where('category_id', $categoryId)->get();

        // Повертаємо частковий вигляд для селектора брендів
        return view('partials.brands', compact('brands'));
    }

}
