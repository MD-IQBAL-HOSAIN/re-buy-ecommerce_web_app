<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'language_id',
        'question',
        'answer',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the language associated with the FAQ.
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
