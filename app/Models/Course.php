<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['code', 'title', 'description', 'credit_hours'];

    public function classes(): HasMany
    {
        return $this->hasMany(ClassSection::class);
    }
}