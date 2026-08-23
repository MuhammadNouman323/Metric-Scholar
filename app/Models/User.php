<?php

namespace App\Models;

use App\Enums\Role;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password', 'role', 'department', 'admin_id', 'access_level', 'university_id', 'created_by', 'is_active', 'password_change_required', 'avatar', 'phone'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'password_change_required' => 'boolean',
            'role' => Role::class,
        ];
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdUsers(): HasMany
    {
        return $this->hasMany(User::class, 'created_by');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)->withPivot('term')->withTimestamps();
    }

    public function feedbackAccess(): HasMany
    {
        return $this->hasMany(FeedbackAccess::class);
    }

    public function facultyFeedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class, 'faculty_id');
    }

    public function evaluations(): BelongsToMany
    {
        return $this->belongsToMany(Evaluation::class, 'evaluation_faculty', 'faculty_id', 'evaluation_id');
    }

    public function feedbackTokens(): HasMany
    {
        return $this->hasMany(FeedbackToken::class, 'student_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::Admin;
    }

    public function isFaculty(): bool
    {
        return $this->role === Role::Faculty;
    }

    public function isStudent(): bool
    {
        return $this->role === Role::Student;
    }

    public function getAvatarUrlAttribute(): string
    {
        if (! empty($this->avatar)) {
            return Storage::disk('public')->url($this->avatar);
        }

        $initials = collect(explode(' ', $this->name))
            ->map(fn ($part) => mb_substr($part, 0, 1))
            ->take(2)
            ->implode('');

        return 'data:image/svg+xml,'.rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"><rect width="40" height="40" fill="#0e48c1" rx="8"/><text x="20" y="20" text-anchor="middle" dominant-baseline="central" font-family="system-ui,sans-serif" font-size="16" font-weight="600" fill="#fff">'.$initials.'</text></svg>');
    }
}
