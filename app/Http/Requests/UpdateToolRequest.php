<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateToolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('tool')?->id ?? $this->route('tool');
        return [
            'code'        => 'sometimes|required|string|max:50|unique:tools,code,'.$id,
            'name'        => 'sometimes|required|string|max:80|unique:tools,name,'.$id,
            'model'       => 'sometimes|required|string|max:80',
            'description' => 'sometimes|nullable|string',
            'line_id'     => 'sometimes|nullable|integer|exists:production_lines,id',
            'active'      => 'sometimes|boolean',
        ];
    }
}
