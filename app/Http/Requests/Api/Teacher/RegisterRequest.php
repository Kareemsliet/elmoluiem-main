<?php

namespace App\Http\Requests\Api\Teacher;

use App\Enums\CourseTypesEnums;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to send this request
    }

    public function rules()
    {
        $courseTypes=array_map(function($item){
            return $item->value;
        },CourseTypesEnums::cases());

        $courseTypes=implode(",",$courseTypes);

        return [
            'name' => ['required', 'string', 'max:255',"unique:teachers,name"],
            'email' => ['required', 'email',"unique:teachers,email"],
            'password' => ['required', 'min:8'],
            'phone' => ['required', 'string', 'max:255',"unique:teachers,phone"],           
            "education_level_id"=>"required|exists:education_levels,id",
            'course_type' => "required|array|min:1",
            "course_type.*" =>"required|string|in:$courseTypes",
            "subjects" =>"required|array|min:1",
            "subjects.*"=>"required|string|exists:subjects,id",
            "gender"=>"required|in:male,female"
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }
}
