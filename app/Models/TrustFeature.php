<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TrustFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id',
        'title',
        'icon',
    ];
    protected $casts = [
        'icon' => 'string',
    ];
    /**
     * Accessor for icon to return full URL in API requests
     */
    protected function icon(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            request()->is('api/*') && !empty($value)
            ? url($value)
            : $value
        );
    }

    /**
     * Get the language associated with the TrustFeature.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
