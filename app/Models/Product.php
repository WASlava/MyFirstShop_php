<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property float $price
 * @property boolean $is_favorite
 * @property int $brand_id
 * @property Brand $brand
 * @property int $category_id
 * @property Category $category
 * @property ProductImage[] $images
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'price',
        'description',
        'is_favorite',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}
