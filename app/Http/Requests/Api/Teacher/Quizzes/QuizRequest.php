<?php

namespace App\Http\Requests\Api\Teacher\Quizzes;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
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
        $teacher = $this->user("teacher");

        $quiz = $this->route("quiz",0);

        return [
            'title' => [
                "required",
                "string",
                "max:255",
                function ($attribute, $value, $fail) use ($teacher,$quiz) {
                    if ($teacher->quizzes()->whereNot('id',$quiz)->where("title","=",$value)->exists()) {
                        return $fail('A quiz with this title already exists.');
                    }
                }
            ],
            'academic_year' => 'required|integer',
            'start_time' => 'required|date_format:H:i|before:end_time',
            'end_time' => 'required|date_format:H:i',
            'time_limit' => 'required|integer|min:1',
            'date' => 'required|date|date_format:Y-m-d',
            'subject_id' => 'required|integer|exists:subjects,id',
            'education_level_id' => 'required|integer|exists:education_levels,id',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return failResponse($validator->errors()->first());
    }

}
