<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassSection extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'course_id', 'teacher_id', 'room',
        'day_of_week', 'start_time', 'end_time', 'capacity',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    public function activeEnrollmentCount(): int
    {
        return $this->enrollments()->where('status', 'active')->count();
    }

    public function hasAvailableSeats(): bool
    {
        return $this->activeEnrollmentCount() < $this->capacity;
    }
}