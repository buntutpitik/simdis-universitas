<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIncomingLetterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'letter_number' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'received_date' => 'required|date',
            'sender' => 'required|string|max:255',
            'regarding' => 'required|string|max:255',
            'priority' => 'required',
            'attachment' => 'nullable|string|max:255',
            'description' => 'nullable|string',

            // Saat update PDF boleh kosong
            'file' => 'nullable|mimes:pdf|max:5120',
        ];
    }
}