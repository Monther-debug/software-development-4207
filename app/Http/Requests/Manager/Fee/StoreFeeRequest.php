<?php

namespace App\Http\Requests\Manager\Fee;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gradeID' => 'required|exists:grades,id',
            'amount' => 'required|numeric|min:0',
        ];
    }
}
