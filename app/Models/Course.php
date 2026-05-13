<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    protected $fillable = [
        'title',
        'code',
        'semester',
        'credit_hours',
        'department',
    ];

    public function faculty(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('term')->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
