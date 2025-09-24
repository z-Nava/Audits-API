<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'line_id' => 'sometimes|required|integer|exists:production_lines,id',
            'shift' => 'sometimes|required|in:A,B,C',
            'due_at' => 'sometimes|nullable|date|after_or_equal:assigned_at',
            'notes' => 'sometimes|nullable|string',
        ];
    }
}
