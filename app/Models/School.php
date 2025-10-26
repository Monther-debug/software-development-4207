<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'status',
        'type',
        'level',
    ];

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'schools_teachers', 'schoolID', 'teacherID')
            ->withPivot('gradeID')
            ->withTimestamps();
    }
}
