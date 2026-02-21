<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CMS extends Model
{
    protected $fillable = [
        'language_id',
        'name',
        'title',
        'subtitle',
        'button_text_one',
        'button_text_two',
        'email_text',
        'phone',
        'checkout',
        'total',
        'continue',
        'back',
        'place_order',
        'add_to_cart',
        'buy_now',
        'shipping',
        'payment',
        'review',
        'return',
        'order_summary',
        'customer_details',
        'subtotal',
        'products',
        'contact',
        'city',
        'postal_code',
        'country',
        'description',
        'content',
        'image',
        'image_two',
        'image_three',
        'image_four',
        'image_five',
        'slug',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    /*
     * Accessors for images to return full URL in API requests
     *
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

    protected function imageTwo(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            request()->is('api/*') && !empty($value)
                ? url($value)
                : $value
        );
    }
    protected function imageThree(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            request()->is('api/*') && !empty($value)
                ? url($value)
                : $value
        );
    }
    protected function imageFour(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            request()->is('api/*') && !empty($value)
                ? url($value)
                : $value
        );
    }
    protected function imageFive(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            request()->is('api/*') && !empty($value)
                ? url($value)
                : $value
        );
    }

    /**
     * Get the language associated with the CMS entry.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
