<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreToolRequest extends FormRequest
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
            'code'        => 'required|string|max:50|unique:tools,code',
            'name'        => 'required|string|max:80|unique:tools,name',
            'model'       => 'required|string|max:80',
            'description' => 'nullable|string',
            'line_id'     => 'nullable|integer|exists:production_lines,id',
            'active'      => 'sometimes|boolean',
        ];
    }
}
