<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProtectionService extends Model
{
    protected $fillable = [
        'language_id',
        'name',
        'description',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the products that have this protection service (Many-to-Many).
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_protection_service')
            ->withTimestamps();
    }

    /**
     * Get the language associated with the protection service.
     */
     public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
