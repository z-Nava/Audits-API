<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
        $id = $this->route('employee')->id ?? $this->route('employee');

        return [
            'employee_number' => 'sometimes|required|string|max:5|unique:employees,employee_number,' . $id,
            'name' => 'sometimes|required|string|max:100',
            'registered_by' => 'sometimes|required|integer|exists:users,id',
            'active' => 'sometimes|boolean',
        ];
    }
}
