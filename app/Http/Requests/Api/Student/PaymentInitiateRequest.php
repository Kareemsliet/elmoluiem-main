<?php

namespace App\Http\Requests\Api\Student;

use Illuminate\Foundation\Http\FormRequest;

class PaymentInitiateRequest extends FormRequest
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
            "amount" => "required|numeric|min:5",
            "wallet_number" => "required|numeric",
            "orderable_type" => "required|string|in:lessons,courses",
            "orderable_id" => $this->whenHas("orderable_type", function(){
                if ($this->input("orderable_type") == "lessons") {
                    return "required|exists:lessons,id|numeric";
                }
            },function(){
                return "required|numeric";
            }),
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }
}
