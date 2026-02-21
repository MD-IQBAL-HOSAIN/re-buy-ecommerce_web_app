<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SellElectronics extends Model
{
    protected $fillable = [
        'language_id',
        'name',
        'image',
        'description',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price' => 'float',
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
     * Get the language associated with the sell electronic.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
