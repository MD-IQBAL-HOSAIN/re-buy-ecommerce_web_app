<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Review extends Model
{
    protected $fillable = [
        'language_id',
        'product_id',
        'user_id',
        'rating',
        'review_text',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the language that the review belongs to.
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
    /**
     * Get the product that the review belongs to.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that the review belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
