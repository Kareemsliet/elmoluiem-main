<?php

namespace App\Http\Requests\Api\Student;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
        $student=$this->user("student")->id;

        return [
            'name' => "required|string|max:255|unique:students,name,$student",
            'email' => "required|email|unique:students,email,$student",
            "education_level_id"=>"required|exists:education_levels,id",
            'phone' => "required|string|max:20|unique:students,phone,$student",
            'address' => "required|string|max:255",
            "gender"=>"required|in:male,female",
            "description"=>"nullable|string|max:250",
            "profile_image"=>"nullable|image|max:25000|mimes:png,jpg,svg",
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }

}
