<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rateable_type',
        'rateable_id',
        'author',
        'score',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'integer',
        ];
    }

    public function rateable()
    {
        return $this->morphTo();
    }
}
