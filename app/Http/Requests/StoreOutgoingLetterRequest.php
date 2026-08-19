<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutgoingLetterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'letter_number' => [
                'required',
                'string',
                'max:255',
            ],

            'letter_date' => [
                'required',
                'date',
            ],

            'recipient' => [
                'required',
                'string',
                'max:255',
            ],

            'regarding' => [
                'required',
                'string',
                'max:255',
            ],

            'priority' => [
                'required',
                'in:Biasa,Penting,Segera,Rahasia',
            ],

            'attachment' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'file' => [
                'required',
                'file',
                'mimes:pdf',
                'max:2048',
            ],

        ];
    }
}