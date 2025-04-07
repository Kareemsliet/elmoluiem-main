<?php

namespace App\Http\Requests\Api\Teacher\Lessons;

use App\Rules\UniqueColumnById;
use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
        $lesson=$this->route("lesson",0);
        
        return [
            "price"=>"required|numeric",
            "logo"=>$this->when(function(){
                return $this->getMethod()=="POST";
            },function(){
                return "required|image|max:15000|mimes:png,jpg,svg";
            },function(){
                return "nullable|image|max:15000|mimes:png,jpg,svg";
            }),
            "title"=>["required","string","max:100",new UniqueColumnById("lessons",'title','teachers','teacher_id',$lesson)],
            "description"=>"required|string|max:250",
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }

}
