<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Показати всі категорії
    public function index()
    {
        $categories = Category::with('parentCategory')->get();
        return view('categories.index', compact('categories'));
    }
//    public function index()
//    {
//        // Отримуємо основні категорії з дочірніми
//        $categories = Category::whereNull('parent_category_id')->with('childCategories')->get();
//
//        return view('categories.index', compact('categories'));
//    }


    // Показати конкретну категорію
    public function show($id)
    {
        $category = Category::with('parentCategory', 'products')->findOrFail($id);
        return view('categories.show', compact('category'));
    }

    // Форма створення нової категорії
    public function create()
    {
        $parentCategories = Category::whereNull('parent_category_id')->get();
        return view('categories.create', compact('parentCategories'));
    }

    // Зберегти нову категорію
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'parent_category_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    // Форма редагування категорії
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parentCategories = Category::whereNull('parent_category_id')->get();
        return view('categories.edit', compact('category', 'parentCategories'));
    }

    // Оновити категорію
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'parent_category_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    // Видалити категорію
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
