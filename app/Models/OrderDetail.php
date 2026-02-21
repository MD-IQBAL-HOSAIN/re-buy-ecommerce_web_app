<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'product_id',
        'color_id',
        'storage_id',
        'accessory_id',
        'protection_services',
        'quantity',
        'unit_price',
        'accessory_price',
        'protection_services_price',
        'total_price',
    ];

    protected $casts = [
        'protection_services' => 'array',
        'unit_price' => 'decimal:2',
        'accessory_price' => 'decimal:2',
        'protection_services_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

     protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the order that owns the order detail.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with the order detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the color associated with the order detail.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the storage associated with the order detail.
     */
    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    /**
     * Get the accessory associated with the order detail.
     */
    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }
}
