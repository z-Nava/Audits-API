<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuditReviewRequest extends FormRequest
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
            'decision'      => 'required|in:approved,rejected,needs_changes',
            'notes'         => 'sometimes|nullable|string',
            'reviewed_at'   => 'sometimes|nullable|date',
        ];
    }
}
