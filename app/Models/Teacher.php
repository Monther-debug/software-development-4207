<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Teacher extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_id',
        'grade_id',
        'name',
        'email',
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'schools_teachers', 'teacherID', 'schoolID')
            ->withPivot('gradeID')
            ->withTimestamps();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
