<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $fillable = [
        'language_id',
        'name',
        'description',
        'price',
        'previous_price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'previous_price' => 'decimal:2',
    ];

    /**
     * Get the products that have this accessory (Many-to-Many).
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_accessory')
            ->withTimestamps();
    }

    /**
     * Get the language associated with the accessory.
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
