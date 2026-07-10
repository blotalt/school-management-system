<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = ['user_id', 'student_no', 'enrollment_date'];

    protected $casts = [
        'enrollment_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function enrollments(): HasMany
{
    return $this->hasMany(Enrollment::class);
}
}