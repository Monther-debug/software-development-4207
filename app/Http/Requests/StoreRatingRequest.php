<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'schoolID' => 'required|integer|exists:schools,id',
            'rating' => 'required|string|in:1,2,3,4,5',
            // userID is set automatically from auth()->id()
        ];
    }
}
