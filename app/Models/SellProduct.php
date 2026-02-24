<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SellProduct extends Model
{
    protected $table = 'sell_products';

    protected $fillable = [
        'language_id',
        'buy_subcategory_id',
        'name',
        'short_name',
        'slug',
        'image',
        'description',
        'storage',
        'color',
        'model',
        'ean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Accessor for image attribute to return full URL in API responses
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            request()->is('api/*') && ! empty($value)
                ? url($value)
                : $value
        );
    }

    /*
    * Relationships in SellProduct Model
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /*
     * Relationships in SellProduct Model
     */

    public function buySubcategory()
    {
        return $this->belongsTo(BuySubcategory::class);
    }

    /**
     * Get the questions for the sell product.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
