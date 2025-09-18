<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductionLineRequest extends FormRequest
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
        $id = $this->route('line')->id ?? $this->route('line');
        return [
            'code' => 'required|string|max:50|unique:production_lines,code,' . $id,
            'name' => 'required|string|max:120',
            'area' => 'nullable|string|max:120',
            'active' => 'sometimes|boolean',    
        ];
    }
}
