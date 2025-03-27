<?php

namespace App\Http\Requests\Api\Student;

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
            'name' => 'required|string|max:255|unique:students,name',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|min:8',
            "education_level_id"=>"required|exists:education_levels,id",
            'phone' => 'required|string|max:20|unique:students,phone',
            'address' => 'required|string|max:255',
            "gender"=>"required|in:male,female"
        ];
    }


    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return failResponse($validator->errors()->first());
    }

}
