<?php

namespace App\Http\Requests\User\Rating;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'schoolID' => 'required|exists:schools,id',
            'rating' => 'required|in:1,2,3,4,5',
        ];
    }
}
