<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'teacher_id', 'room', 'day', 'start_time', 'end_time', 'capacity'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments');
    }

    public function enrolledCount(): int
    {
        return $this->enrollments()->count();
    }

    public function isFull(): bool
    {
        return $this->enrolledCount() >= $this->capacity;
    }
}
