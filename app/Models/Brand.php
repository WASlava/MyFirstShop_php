<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $brand_name
 * @property string $country
 *
 * @property Product[] $products
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = [
        'brand_name',
        'country',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }
}
