<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
