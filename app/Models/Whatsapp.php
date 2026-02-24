<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Whatsapp extends Model
{
    protected $fillable = [
        'number',
    ];

     protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
