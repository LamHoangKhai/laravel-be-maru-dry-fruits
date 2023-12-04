<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "email" => "required|unique:users",
            "full_name" => "required",
            "password" => "required|min:8",
            "confirm_password" => "required|same:password",
            "phone" => "required|max:15|min:10|regex:/^([0-9\s\-\+\(\)]*)$/",
            "address" => "required"
        ];
    }
}
