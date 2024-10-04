<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int|null $parent_id
 * @property string $category_name
 *
 * @property Category|null $parent
 * @property Category[] $children
 *
 * @property Product[] $products
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'parent_category_id',
    ];

    public function childCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'id');
    }

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }

    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }
}
