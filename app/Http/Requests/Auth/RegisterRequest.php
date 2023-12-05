<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please enter your email',
            'email.email' => 'It\'s not an email',
            'email.unique' => 'This email was exist',
            'password.required' => 'Please enter your password',
            'password.confirmed' => 'Password confirmation is not correct',
            'password.min' => 'Password must be at least 6 charactors',
        ];
    }
}
