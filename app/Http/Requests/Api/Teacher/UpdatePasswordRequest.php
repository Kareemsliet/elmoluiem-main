<?php

namespace App\Http\Requests\Api\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow authenticated users
    }

    public function rules()
    {
        return [
            "email"=>"required|string|exists:teachers,email",
            "password"=>"required|confirmed|min:8",
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }
}
