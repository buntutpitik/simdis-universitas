<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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

            'full_name' => ['required','string','max:255'],

            'email' => ['required','email','unique:users,email'],

            'password' => ['required','confirmed','min:8'],

            'position_id' => ['required','exists:positions,id'],

            'role' => ['required'],

            'phone' => ['nullable','max:20'],

            'avatar' => ['nullable','image','max:2048'],

            'is_active' => ['required','boolean'],

        ];
    }
}
