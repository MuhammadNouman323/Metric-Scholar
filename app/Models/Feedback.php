<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    protected $fillable = [
        'anonymous_token',
        'course_id',
        'faculty_id',
        'clarity',
        'materials',
        'responsiveness',
        'fairness',
        'practical',
        'organization',
        'overall_rating',
        'comments',
        'what_worked_well',
        'what_could_improve',
        'recommendation',
    ];

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
