<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $order_id
 * @property Order $order
 * @property Product $product
 * @property int $product_id
 * @property float $price
 * @property int $quantity
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products';

    protected $fillable = [
        'quantity',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
