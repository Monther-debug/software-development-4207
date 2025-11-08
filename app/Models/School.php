<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'status',
        'type',
        'level',
    ];

    public function managers()
    {
        return $this->hasMany(Manager::class, 'schoolID');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'schoolID');
    }

    public function successRatings()
    {
        return $this->hasMany(SuccessRating::class, 'schoolID');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'schoolID');
    }

    public function fees()
    {
        return $this->hasMany(Fee::class, 'schoolID');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'schools_teachers', 'schoolID', 'teacherID')
            ->withPivot('gradeID', 'year')
            ->withTimestamps();
    }
}
