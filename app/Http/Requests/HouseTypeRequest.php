<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class HouseTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'house_type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'house_type.required' => "tipe rumah harap diisi!",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $result = new JsonResponse([
            'meta' => [
                'message' => $validator->errors(),
                'status_code' => 400
            ]
        ]);

        throw new ValidationException($validator, $result);
    }
}
