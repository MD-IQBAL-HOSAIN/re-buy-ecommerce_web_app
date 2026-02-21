<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class HowItWork extends Model
{
    protected $table = 'how_it_works';

    protected $fillable = [
        'language_id',
        'title',
        'subtitle',
        'image',
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
     * Get the language associated with the how it works record.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
