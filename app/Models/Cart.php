<?php


namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'color_id',
        'storage_id',
        'protection_services',
        'accessory_id',
        'quantity',
        'product_price',
        'accessory_price',
        'protection_services_price',
        'total_price',
    ];

    protected $casts = [
        'protection_services' => 'array',
        'product_price' => 'decimal:2',
        'accessory_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'protection_services_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the cart item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product in the cart.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the selected color.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the selected storage.
     */
    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    /**
     * Get the selected accessory.
     */
    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }

    /**
     * Get the customer information for the cart.
     */
    public function customerInformation()
    {
        return $this->belongsTo(CustomerInformation::class, 'customer_information_id');
    }
}
