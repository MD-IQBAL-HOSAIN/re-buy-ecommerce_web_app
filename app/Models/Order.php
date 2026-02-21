<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'payment_id',
        'order_number',
        'delivery_fee',
        'total_amount',
        'payment_status',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order details for the order.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
