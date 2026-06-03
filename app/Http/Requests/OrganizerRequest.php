<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrganizerRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'organization_name' => 'nullable|string|max:255',
            'event_type'        => 'required|string|max:255',
            'website'           => 'nullable|url|max:255',
            'experience'        => 'nullable|string',
            'motivation'        => 'required|string',
        ];
    }
}
