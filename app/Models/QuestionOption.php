<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $fillable = [
        'question_id',
        'option',
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
     * Relationships in QuestionOption Model
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
