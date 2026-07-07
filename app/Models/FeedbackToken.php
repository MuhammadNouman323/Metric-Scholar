<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackToken extends Model
{
    protected $fillable = [
        'evaluation_id',
        'student_id',
        'faculty_id',
        'course_id',
        'token',
        'is_used',
        'used_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function faculty()
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
