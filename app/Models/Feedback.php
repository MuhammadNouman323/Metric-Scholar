<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'evaluation_id',
        'faculty_id',
        'course_id',
        'submitted_at',
        'worked_well',
        'improve',
        'worked_status',
        'improve_status',
        'worked_score',
        'improve_score',
        'worked_reason',
        'improve_reason',
    ];

    public $timestamps = true;

    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function answers()
    {
        return $this->hasMany(FeedbackAnswer::class);
    }
}
