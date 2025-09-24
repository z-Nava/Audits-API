<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest
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
            'supervisor_id' => 'required|integer|exists:users,id',
            'technician_id' => 'required|integer|exists:users,id|different:supervisor_id',
            'line_id' => 'required|integer|exists:production_lines,id',
            'shift' => 'required|in:A,B,C',
            'assigned_at' => 'required|date',
            'due_at' => 'nullable|date|after_or_equal:assigned_at',
            'notes' => 'nullable|string',
        ];
    }
}
