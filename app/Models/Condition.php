<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $fillable = [
        'language_id',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the products with this condition.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the language associated with the condition.
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
