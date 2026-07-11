<?php

namespace App\Models;

<<<<<<< HEAD
use App\Enums\EnrollmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
>>>>>>> 66d8f5d381b1b29fb8af794d4b8e63d6c8a63af7
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
<<<<<<< HEAD
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
=======
    protected $fillable = ['student_id', 'class_id', 'enrolled_at', 'status'];
>>>>>>> 66d8f5d381b1b29fb8af794d4b8e63d6c8a63af7

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function classSection(): BelongsTo
    {
<<<<<<< HEAD
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
=======
        return $this->belongsTo(ClassSection::class, 'class_id');
    }
}
>>>>>>> 66d8f5d381b1b29fb8af794d4b8e63d6c8a63af7
