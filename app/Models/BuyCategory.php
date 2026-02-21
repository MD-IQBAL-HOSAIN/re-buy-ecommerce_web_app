<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BuyCategory extends Model
{
    protected $fillable = [
        'language_id',
        'name',
        'slug',
        'image',
        'status',
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
                ? url($value)
                : $value
        );
    }

    /**
     * Get the language that owns the buy category.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the subcategories for the buy category.
     */
    public function buySubCategories()
    {
        return $this->hasMany(BuySubcategory::class);
    }
}
