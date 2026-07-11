<?php

namespace App\Models;

use App\Enums\EnrollmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    /** @use HasFactory<\Database\Factories\EnrollmentFactory> */
    use HasFactory;

    protected $fillable = [
        'student_id',
        'class_section_id',
        'status',
        'enrolled_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => EnrollmentStatus::class,
            'enrolled_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function classSection(): BelongsTo
    {
        return $this->belongsTo(ClassSection::class);
    }

    /**
     * Scope to enrollments that currently occupy a seat.
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', EnrollmentStatus::occupyingSeat());
    }
}
