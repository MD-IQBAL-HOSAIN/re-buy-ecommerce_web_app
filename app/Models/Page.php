<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'language_id',
        'page_title',
        'page_content',
        'status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the language associated with the page.
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
