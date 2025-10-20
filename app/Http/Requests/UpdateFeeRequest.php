<?php

namespace App\Http\Requests;

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
            'school_id' => 'sometimes|exists:schools,id',
            'grade_id' => 'nullable|exists:grades,id',
            'name' => 'sometimes|string|max:255',
            'code' => 'sometimes|string|max:50',
            'amount' => 'sometimes|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'frequency' => 'in:once,monthly,term,annual',
            'status' => 'in:active,inactive',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string',
        ];
    }
}
