<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $fillable = [
        'product_id',
        'color_id',
        'extra_price',
        'stock',
    ];

    protected $casts = [
        'extra_price' => 'decimal:2',
    ];

    /**
     * Get the product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the color.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
