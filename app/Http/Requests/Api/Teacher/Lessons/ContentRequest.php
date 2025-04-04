<?php

namespace App\Http\Requests\Api\Teacher\Lessons;

use App\Rules\UniqueColumnById;
use Illuminate\Foundation\Http\FormRequest;

class ContentRequest extends FormRequest
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
        $content=$this->route("content",0);

        return [
            "title"=>["required","string","max:150",new UniqueColumnById("contents","title","lessons","contentable_id",$content)],
            "description"=>"required|string|max:250",
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }

}
