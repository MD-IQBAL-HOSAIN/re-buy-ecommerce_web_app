<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'language_id',
        'code',
        'name',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the products that have this color (Many-to-Many).
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_color')
            ->withPivot('extra_price', 'stock')
            ->withTimestamps();
    }


    /**
     * Get the language associated with the color.
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    /**
     * Get the carts that have this color.
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
