<?php

namespace App\Http\Requests\Api\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to send this request
    }

    public function rules()
    {
        return [
            "email"=>"required|string|email|exists:teachers,email",
            "password"=>"required|string|min:8",
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }
}
