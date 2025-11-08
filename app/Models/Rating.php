<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'schoolID',
        'userID',
        'rating',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'string',
        ];
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'schoolID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
