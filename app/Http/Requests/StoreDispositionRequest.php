<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDispositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'incoming_letter_id' => [
                'required',
                'exists:incoming_letters,id',
            ],

            'recipient_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'recipient_ids.*' => [
                'required',
                'integer',
                'exists:users,id',
                'distinct',
            ],

            'instruction' => [
                'nullable',
                'string',
            ],

            'note' => [
                'nullable',
                'string',
            ],

            'priority' => [
                'required',
                'in:Biasa,Penting,Segera,Rahasia',
            ],

            'deadline' => [
                'nullable',
                'date',
            ],

        ];
    }
}