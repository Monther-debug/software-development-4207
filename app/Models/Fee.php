<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'schoolID',
        'gradeID',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
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
