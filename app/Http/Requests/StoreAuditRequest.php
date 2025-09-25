<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuditRequest extends FormRequest
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
            'assignment_id'   => 'required|integer|exists:assignments,id',
            'technician_id'   => 'required|integer|exists:users,id',
            'employee_number' => 'required|string|max:50', // se valida contra employees en el Service
            'shift'           => 'required|in:A,B,C',
            'summary'         => 'sometimes|nullable|string',
            'started_at'      => 'sometimes|nullable|date',
        ];
    }
}
