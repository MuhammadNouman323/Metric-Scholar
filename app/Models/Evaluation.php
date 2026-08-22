<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
                    // fallback to any existing admin, deterministically (tests may create faculty/student only)
                    $adminId = User::where('role', Role::Admin)->orderBy('id')->value('id');
                    if ($adminId) {
                        $model->created_by = $adminId;
                    } else {
                        $anyId = User::orderBy('id')->value('id');
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

    /**
     * Number of students currently eligible for this evaluation, computed from
     * live course enrollment instead of the tokens generated at publish time.
     */
    public function eligibleStudentsCount(): int
    {
        return (int) static::eligibleStudentsCounts([$this->id])->get($this->id, 0);
    }

    /**
     * Bulk eligible-student counts keyed by evaluation id.
     *
     * @param  array<int, int>  $evaluationIds
     * @return Collection<int|string, int>
     */
    public static function eligibleStudentsCounts(array $evaluationIds): Collection
    {
        if ($evaluationIds === []) {
            return collect();
        }

        return DB::table('evaluation_courses')
            ->join('course_user', 'course_user.course_id', '=', 'evaluation_courses.course_id')
            ->join('users', 'users.id', '=', 'course_user.user_id')
            ->whereIn('evaluation_courses.evaluation_id', $evaluationIds)
            ->where('users.role', Role::Student->value)
            ->groupBy('evaluation_courses.evaluation_id')
            ->selectRaw('evaluation_courses.evaluation_id, COUNT(DISTINCT course_user.user_id) as eligible_students')
            ->pluck('eligible_students', 'evaluation_courses.evaluation_id');
    }
}
