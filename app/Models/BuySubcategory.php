<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class BuySubcategory extends Model
{
    protected $fillable = [
        'buy_category_id',
        'name',
        'slug',
        'image',
        'status',
        'is_featured',
    ];
    
    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the image attribute with URL for API requests.
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            request()->is('api/*') && ! empty($value)
                ? url($value)
                : $value
        );
    }

    /**
     * Get the buy category that owns the buy subcategory.
     */
    public function buyCategory()
    {
        return $this->belongsTo(BuyCategory::class);
    }

    /**
     * Get the products for the subcategory.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the sell products for the subcategory.
     */
    public function sellProducts()
    {
        return $this->hasMany(SellProduct::class);
    }

}
