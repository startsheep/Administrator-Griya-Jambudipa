<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ImportRequest extends FormRequest
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
            'file' => 'required|mimes:application/vnd.ms-excel,xlsx,xls'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => "file harap diisi!",
            'file.mimes' => "file harap berisi :mimes!",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $result = new JsonResponse([
            'meta' => [
                'message' => $validator->errors(),
                'status_code' => 400
            ]
        ] , 400);

        throw new ValidationException($validator, $result);
    }
}
