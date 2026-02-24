<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SellBannerImage extends Model
{
    protected $table = 'sell_banner_images';

    protected $fillable = [
        'image',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the image attribute with URL for API requests.
     */
    /*
     * Accessors for images to return full URL in API requests
     *
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
}
