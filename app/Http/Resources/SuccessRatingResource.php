<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessRatingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'schoolID' => $this->schoolID,
            'gradeID' => $this->gradeID,
            'total_students' => $this->total_students,
            'A' => $this->A,
            'B' => $this->B,
            'C' => $this->C,
            'D' => $this->D,
        ];
    }
}
