<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        return strtolower((string) $this->role) === 'admin';
    }

    public function isFaculty(): bool
    {
        return strtolower((string) $this->role) === 'faculty';
    }

    public function isStudent(): bool
    {
        return strtolower((string) $this->role) === 'student';
    }

    public function getAvatarUrlAttribute(): string
    {
        if (! empty($this->avatar)) {
            return Storage::disk('public')->url($this->avatar);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=0e48c1&color=fff';
    }
}
