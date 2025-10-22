<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'rateable_type' => 'required|string',
            'rateable_id' => 'required|integer',
            'author' => 'nullable|string|max:255',
            'score' => 'required|integer|min:1|max:5',
            'note' => 'nullable|string',
        ];
    }
}
