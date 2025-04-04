<?php

namespace App\Http\Requests\Api\Teacher\Lessons;

use App\Rules\UniqueColumnById;
use Illuminate\Foundation\Http\FormRequest;

class LectureRequest extends FormRequest
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
        $lecture=$this->route("lecture",0);

        return [
            "title" => ["required","string","max:100",new UniqueColumnById("lectures",'title',"contents",'content_id',$lecture)],
            "description" => "required|string",
            "deuration" => "required|integer",
            "video" => $this->when(function () {
                return $this->getMethod() == "POST";
            }, function () {
                return "required|mimes:mp4|mimetypes:video/mp4|max:10000";
            }, function () {
                return "nullable|mimes:mp4|mimetypes:video/mp4|max:10000";
            }),
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return failResponse($validator->errors()->first());
    }

}
