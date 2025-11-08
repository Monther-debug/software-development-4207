<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'schoolID' => $this->schoolID,
            'gradeID' => $this->gradeID,
            'amount' => $this->amount,
        ];
    }
}
