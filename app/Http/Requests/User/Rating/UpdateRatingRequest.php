<?php

namespace App\Http\Requests\User\Rating;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rating' => 'sometimes|in:1,2,3,4,5',
        ];
    }
}
