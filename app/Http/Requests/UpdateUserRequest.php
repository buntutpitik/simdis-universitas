<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'full_name' => ['required', 'max:255'],

            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->route('user')),
            ],

            'position_id' => ['required', 'exists:positions,id'],

            'role' => ['required'],

            'phone' => ['nullable', 'max:20'],

            'avatar' => ['nullable', 'image', 'max:2048'],

            'password' => ['nullable', 'confirmed', 'min:8'],

            'is_active' => ['required', 'boolean'],

        ];
    }
}