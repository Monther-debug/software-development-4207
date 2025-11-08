<?php

namespace App\Http\Requests\User\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'schoolID' => 'required|exists:schools,id',
            'comment' => 'required|string',
        ];
    }
}
