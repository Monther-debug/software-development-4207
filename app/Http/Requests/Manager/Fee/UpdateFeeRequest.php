<?php

namespace App\Http\Requests\Manager\Fee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gradeID' => 'sometimes|exists:grades,id',
            'amount' => 'sometimes|numeric|min:0',
        ];
    }
}
