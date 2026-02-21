<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'sell_product_id',
        'question_price',
        'option_price',
        'answers',
        'user_info',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'question_price' => 'float',
        'option_price'   => 'float',
        'answers'        => 'array',
        'user_info'      => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sellProduct()
    {
        return $this->belongsTo(SellProduct::class);
    }
}
