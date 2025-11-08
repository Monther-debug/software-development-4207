<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'schoolID',
        'userID',
        'comment',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'schoolID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
