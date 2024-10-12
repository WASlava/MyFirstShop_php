<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    // Вказуємо, чи дозволено авторизованим користувачам виконувати цей запит
    public function authorize()
    {
        return true;
    }

    // Правила валідації для створення продукту
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    // Повідомлення про помилки для кожного поля
    public function messages()
    {
        return [
            'name.required' => 'Product name is required',
            'description.required' => 'Product description is required',
            'price.required' => 'Price is required and must be a positive number',
            'brand_id.required' => 'Please select a valid brand',
            'category_id.required' => 'Please select a valid category',
            'quantity.required' => 'Quantity is required and should be at least 1',
        ];
    }
}
