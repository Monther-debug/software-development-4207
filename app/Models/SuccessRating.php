<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'schoolID',
        'gradeID',
        'total_students',
        'A',
        'B',
        'C',
        'D',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'schoolID');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'gradeID');
    }
}
