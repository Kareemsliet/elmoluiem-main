<?php

namespace App\Http\Requests\Api\Teacher;

use App\Enums\CourseLevelsEnums;
use App\Rules\UniqueColumnById;
use Illuminate\Foundation\Http\FormRequest;

class CoursesRequest extends FormRequest
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
        $course=$this->route("course_id",0);
        
        $courseLevels=array_map(function($level){
            return $level->value;
        },CourseLevelsEnums::cases());

        $courseLevels=implode(",",$courseLevels);

        return [
            "price"=>"required|numeric",
            "image"=>$this->when(function(){
                return $this->getMethod()=="POST";
            },function(){
                return "required|image|max:15000|mimes:png,jpg,svg";
            },function(){
                return "nullable|image|max:15000|mimes:png,jpg,svg";
            }),
            "title"=>["required","string","max:100",new UniqueColumnById("courses",'title','teachers','teacher_id',$course)],
            "description"=>"required|string|max:250",
            "sub_category_id"=>"required|exists:sub_categories,id",
            "level"=>"required|string|lowercase|in:$courseLevels",
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }

}
