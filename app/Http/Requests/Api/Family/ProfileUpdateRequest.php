<?php

namespace App\Http\Requests\Api\Family;

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
        $family=$this->user("family")->id;

        return [
            "name"=>"required|string|max:250|unique:familes,name,$family",
            "email"=>"required|unique:familes,email,$family",
            "phone"=>"required|string|unique:familes,phone,$family",
            "education_level_id"=>"required|exists:education_levels,id",
            "students"=>"required|array|min:1",
            "students.*"=>"required|string|exists:students,phone|numeric",
            "gender"=>"required|in:male,female",
            "description"=>"nullable|string|max:250",
            "profile_image"=>"nullable|image|max:25000|mimes:png,jpg,svg",
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }
}
