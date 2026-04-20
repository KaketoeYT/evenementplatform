<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'datetime' => 'required|date',
            'duration' => 'required|integer|min:1',
            'description' => 'required|string',
            'entry_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'venue_id' => 'required|exists:venues,id',
        ];
    }
}
