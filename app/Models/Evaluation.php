<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evaluation extends Model
{
    protected $fillable = [
        'title',
        'semester',
        'evaluation_type',
        'start_date',
        'end_date',
        'status',
        'is_anonymous',
        'allow_faculty_response',
        'send_reminder',
        'created_by',
        'activated_at',
        'closed_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_anonymous' => 'boolean',
        'allow_faculty_response' => 'boolean',
        'send_reminder' => 'boolean',
        'activated_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->created_by)) {
                if (auth()->check()) {
                    $model->created_by = auth()->id();
                } else {
                    $adminId = User::where('role', Role::Admin)->value('id');
                    if ($adminId) {
                        $model->created_by = $adminId;
                    } else {
                        // fallback to any existing user (tests may create faculty/student only)
                        $anyId = User::value('id');
                        if ($anyId) {
                            $model->created_by = $anyId;
                        }
                    }
                }
            }
        });
    }

    public function faculty(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'evaluation_faculty', 'evaluation_id', 'faculty_id');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'evaluation_courses', 'evaluation_id', 'course_id')
            ->withPivot('faculty_id');
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(FeedbackToken::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function scopeActive($query): void
    {
        $query->where('status', 'active');
    }

    public function scopeScheduled($query): void
    {
        $query->where('status', 'scheduled');
    }

    public function scopeDraft($query): void
    {
        $query->where('status', 'draft');
    }

    public function scopeClosed($query): void
    {
        $query->where('status', 'closed');
    }

    public function scopeArchived($query): void
    {
        $query->where('status', 'archived');
    }
}
