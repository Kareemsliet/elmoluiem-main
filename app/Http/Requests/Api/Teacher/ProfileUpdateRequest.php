<?php

namespace App\Http\Requests\Api\Teacher;

use App\Enums\CourseTypesEnums;
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
        $tecaher=$this->user("teacher")->id;

        $courseTypes=array_map(function($item){
            return $item->value;
        },CourseTypesEnums::cases());

        $courseTypes=implode(",",$courseTypes);

        return [
            'name' => ['required', 'string', 'max:255',"unique:teachers,name,$tecaher"],
            'email' => ['required', 'email',"unique:teachers,email,$tecaher"],
            'phone' => ['required', 'string', 'max:255',"unique:teachers,phone,$tecaher"],           
            "education_level_id"=>"required|exists:education_levels,id",
            'course_type' => "required|array|min:1",
            "course_type.*" =>"required|string|in:$courseTypes",
            "subjects" =>"required|array|min:1",
            "subjects.*"=>"required|string|exists:subjects,id",
            "experince"=>"nullable|integer|numeric",
            "qualification"=>"nullable|string|max:250",
            "description"=>"nullable|max:250",
            "profile_image"=>"nullable|image|max:25000|mimes:png,jpg,svg",
            "cv"=>"nullable|file|max:25000|mimes:pdf,cvs,docx",
            "gender"=>"required|in:male,female",
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }
}
