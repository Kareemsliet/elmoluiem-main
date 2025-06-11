<?php

namespace App\Http\Requests\Api\Teacher\Quizzes;

use Illuminate\Foundation\Http\FormRequest;

class QuestionsRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'score' => 'required|integer|min:0',
            'options' => 'required|array|min:1',
            "options.*" => "array",
            'options.*.title' => 'required|string|max:255',
            'options.*.is_correct' => [
                "required",
                "in:0,1",
            ]
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return failResponse($validator->errors()->first());
    }

}
