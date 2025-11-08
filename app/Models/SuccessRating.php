<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'schoolID',
        'year',
        'success_rate',
        'notes',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'schoolID');
    }
}
