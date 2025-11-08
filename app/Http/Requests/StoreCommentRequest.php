<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'schoolID' => 'required|integer|exists:schools,id',
            'comment' => 'required|string|max:1000',
            // userID is set automatically from auth()->id()
        ];
    }
}
