<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image'
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
            request()->is('api/*') && !empty($value)
                ? (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') ? $value : url($value))
                : $value
        );
    }

    /**
     * Get the product that owns the image.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
