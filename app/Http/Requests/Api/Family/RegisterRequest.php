<?php

namespace App\Http\Requests\Api\Family;

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
            "name"=>"required|string|max:250|unique:familes,name",
            "email"=>"required|unique:familes,email",
            "password"=>"required|min:8",
            "phone"=>"required|string|unique:familes,phone",
            "education_level_id"=>"required|exists:education_levels,id",
            "students"=>"required|array|min:1",
            "students.*"=>"required|string|exists:students,phone|numeric",
            "gender"=>"required|in:male,female"
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }

}
