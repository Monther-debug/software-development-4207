<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'experience',
    ];

    public function schools()
    {
        return $this->belongsToMany(School::class, 'schools_teachers', 'teacherID', 'schoolID')
            ->withPivot('gradeID', 'year')
            ->withTimestamps();
    }
}
