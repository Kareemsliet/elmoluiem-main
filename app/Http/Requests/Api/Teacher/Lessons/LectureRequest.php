<?php

namespace App\Http\Requests\Api\Teacher\Lessons;

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
        return [
            "title" => "required|string|max:100",
            "description" => "required|string",
            "content_id" => "required|exists:contents,id",
            "deuration" => "required|integer",
            "video" => $this->when(function () {
                return $this->method() == "Post";
            }, function () {
                return "required|file|mimes:mp4|mimetypes:video/mp4";
            }, function () {
                return "required|file|mimes:mp4|mimetypes:video/mp4";
            }),
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return failResponse($validator->errors()->first());
    }

}
