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
        'moderation_status',
        'toxicity_score',
        'moderation_reason',
        'moderation_categories',
        'original_comment',
        'cleaned_comment',
        'moderated_at',
    ];

    protected $casts = [
        'moderation_categories' => 'array',
        'moderated_at' => 'datetime',
    ];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}
