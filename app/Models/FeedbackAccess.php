<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackAccess extends Model
{
    protected $table = 'feedback_access';

    protected $fillable = [
        'user_id',
        'course_id',
        'submitted',
    ];

    protected $casts = [
        'submitted' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
