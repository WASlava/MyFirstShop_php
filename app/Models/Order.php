<?php

namespace App\Models;

use App\Models\Enums\OrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

/**
 * @property int $id
 * @property string $comment
 * @property int $status
 * @property int $user_id
 * @property User $user
 * @property OrderProduct[] $orderProducts
 *
 * @property-read $totalAmount
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method Product[] paid()
 * @method Product[] shipped()
 */
class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'status',
        'comment'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function getTotalAmountAttribute(): float
    {
        return $this->orderProducts()->sum('amount * quantity');
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', '=', OrderStatus::PAID);
    }

    public function scopeShipped(Builder $query): Builder
    {
        return $query->where('status', '=', OrderStatus::SHIPPED);
    }
}
