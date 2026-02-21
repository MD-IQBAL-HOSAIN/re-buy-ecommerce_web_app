<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'buy_subcategory_id',
        'condition_id',
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'old_price',
        'discount_price',
        'thumbnail',
        'stock',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'is_featured'    => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the thumbnail attribute with URL for API requests.
     */
    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            request()->is('api/*') && ! empty($value)
                ? (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') ? $value : url($value))
                : $value
        );
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => number_format((float) $value, 2, '.', '')
        );
    }

    protected function oldPrice(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value === null ? null : number_format((float) $value, 2, '.', '')
        );
    }

    protected function discountPrice(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value === null ? null : number_format((float) $value, 2, '.', '')
        );
    }

    /**
     * Get the subcategory that owns the product.
     */
    public function buySubcategory()
    {
        return $this->belongsTo(BuySubcategory::class);
    }

    /**
     * Get the condition of the product.
     */
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    /**
     * Get the images for the product (One-to-Many).
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the colors for the product (Many-to-Many with pivot).
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color')
            ->withPivot('extra_price', 'stock')
            ->withTimestamps();
    }

    /**
     * Get the storage options for the product (Many-to-Many with pivot).
     */
    public function storages()
    {
        return $this->belongsToMany(Storage::class, 'product_storage')
            ->withPivot('extra_price', 'stock')
            ->withTimestamps();
    }

    /**
     * Get the protection services for the product (Many-to-Many).
     */
    public function protectionServices()
    {
        return $this->belongsToMany(ProtectionService::class, 'product_protection_service')
            ->withTimestamps();
    }

    /**
     * Get the accessories for the product (Many-to-Many).
     */
    public function accessories()
    {
        return $this->belongsToMany(Accessory::class, 'product_accessory')
            ->withTimestamps();
    }

    /**
     * Get the reviews for the product (One-to-Many).
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the cart for the product (One-to-Many).
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /*
    * Get the order details for the product (One-to-Many).
    */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
