<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerInformation extends Model
{
    protected $table = 'customer_information';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'country',
        'city',
        'state',
        'postal_code',
    ];

    /**
     * Get the user that owns the customer information.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all carts for this customer information.
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'customer_information_id');
    }
}
