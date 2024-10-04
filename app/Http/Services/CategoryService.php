<?php

namespace App\Http\Services;

use App\Models\Category;

class CategoryService
{
    public function getCategoriesMenu()
    {
        return Category::whereNull('parent_category_id')
            ->with('childCategories.childCategories')
            ->get();
    }
}
