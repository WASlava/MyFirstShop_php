<?php

namespace App\Models;

//use App\Models\Enums\OrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * * @property string $comment
 * * @property int $status
 * * @property int $user_id
 * * @property double $total_amount
 * * @property string $delivery_method
 * * @property string $payment_method
 * * @property string $address_line1
 * * @property string $address_line2
 * * @property string $city
 * * @property string $postal_code
 * * @property string $country
 * * @property User $user
 * * @property OrderProduct[] $orderProducts
 * *
 * * @property-read $totalAmount
 * *
 * * @property Carbon $created_at
 * * @property Carbon $updated_at
 * *
 * * @method Product[] paid()
 * * @method Product[] shipped()
 */
class Order extends Model
{
    use HasFactory;

    /**
     * @var \Closure|mixed|object|null
     */
    public mixed $total_price;
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'status',
        'total_amount',
        'delivery_method',
        'payment_method',
        'address_line1',
        'address_line2',
        'city',
        'postal_code',
        'country',
    ];

    protected $appends = ['status_name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }


    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', '=', OrderStatus::PAID);
    }

    public function scopeShipped(Builder $query): Builder
    {
        return $query->where('status', '=', OrderStatus::SHIPPED);
    }

    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case OrderStatus::NEW:
                return 'Нове';
            case OrderStatus::IN_PROGRESS:
                return 'Готується до висилання';
            case OrderStatus::COMPLETED:
                return 'Завершено';
            case OrderStatus::CANCELED:
                return 'Скасовано';
            case OrderStatus::PAID:
                return 'Очікується оплата';
            case OrderStatus::SHIPPED:
                return 'Відправлено';
            default:
                return 'Невідомий статус';
        }
    }
}
