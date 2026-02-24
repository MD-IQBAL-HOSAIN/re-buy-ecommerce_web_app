<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuySellPartActivity extends Model
{
    protected $fillable = [
        'buy_status',
        'sell_status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
