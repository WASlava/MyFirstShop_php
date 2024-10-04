<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandsController extends Controller
{
    // Показати всі бренди
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    // Показати деталі бренду
    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return view('brands.show', compact('brand'));
    }

    // Показати форму для створення бренду
    public function create()
    {
        return view('brands.create');
    }

    // Зберегти новий бренд
    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        Brand::create([
            'brand_name' => $request->brand_name,
            'country' => $request->country,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully');
    }

    // Показати форму редагування бренду
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('brands.edit', compact('brand'));
    }

    // Оновити існуючий бренд
    public function update(Request $request, $id)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->update([
            'brand_name' => $request->brand_name,
            'country' => $request->country,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully');
    }

    // Видалити бренд
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully');
    }
}
