<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description', 'credits'];

    public function classSections()
    {
        return $this->hasMany(ClassSection::class);
    }
}
