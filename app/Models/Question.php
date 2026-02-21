<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'sell_product_id',
        'question',
        'price',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relationships in Question Model
     */
    public function sellProduct()
    {
        return $this->belongsTo(SellProduct::class);
    }

    /**
     * Get the options for the question.
     */
    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
