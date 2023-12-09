<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            "name" => "required|unique:products,name," . $this->name,
            "price" => "required|regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/",
            "description" => "required",
            "nutrition_detail" => "required",
            "image" => "required|mimes:png,jpg",
        ];
    }
}
