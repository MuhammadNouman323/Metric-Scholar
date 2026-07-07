<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackAnswer extends Model
{
    protected $fillable = [
        'feedback_id',
        'question_id',
        'rating',
        'text_answer',
    ];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}
