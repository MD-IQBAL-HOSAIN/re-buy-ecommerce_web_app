<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $table = 'storages';

    protected $fillable = [
        'language_id',
        'name',
        'capacity',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'capacity' => 'decimal:2',
    ];

    /**
     * Get the products that have this storage (Many-to-Many).
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_storage')
            ->withPivot('extra_price', 'stock')
            ->withTimestamps();
    }

    /**
     * Get the language associated with the storage.
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    /**
     * Get the carts that have this storage.
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
