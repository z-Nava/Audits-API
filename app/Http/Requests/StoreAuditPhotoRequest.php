<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuditPhotoRequest extends FormRequest
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
            'photo'    => 'required|file|mimes:jpg,jpeg,png|max:5120', // 5MB
            'caption'  => 'sometimes|nullable|string|max:160',
            'taken_at' => 'sometimes|nullable|date',
        ];
    }
}
