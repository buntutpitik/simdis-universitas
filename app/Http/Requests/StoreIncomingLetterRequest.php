<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomingLetterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        return [

            'letter_number' => [
                'required',
                'string',
                'max:255',
                'unique:incoming_letters,letter_number',
            ],

            'letter_date' => [
                'required',
                'date',
            ],

            'received_date' => [
                'required',
                'date',
            ],

            'sender' => [
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
                'max:5120', // 5 MB
            ],

        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'letter_number.required' => 'Nomor surat wajib diisi.',
            'letter_number.unique' => 'Nomor surat sudah digunakan.',

            'letter_date.required' => 'Tanggal surat wajib diisi.',
            'received_date.required' => 'Tanggal diterima wajib diisi.',

            'sender.required' => 'Pengirim wajib diisi.',
            'regarding.required' => 'Perihal wajib diisi.',

            'priority.required' => 'Prioritas surat wajib dipilih.',

            'file.required' => 'File surat wajib diupload.',
            'file.mimes' => 'File harus berformat PDF.',
            'file.max' => 'Ukuran file maksimal 5 MB.',

        ];
    }
}