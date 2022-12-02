<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class KavlingRequest extends FormRequest
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
            'house_type' => 'required',
            'block' => 'required',
            'number_kavling' => 'required',
            'width_kavling' => 'required',
            'length_kavling' => 'required',
            'second_length_kavling' => 'required',
            'area_kavling' => 'required',
            'area_building' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'house_type.required' => "tipe rumah harap diisi!",
            'block.required' => "blok harap diisi!",
            'number_kavling.required' => "nomor kavling harap diisi!",
            'width_kavling.required' => "lebar kavling harap diisi!",
            'length_kavling.required' => "panjang kavling harap diisi!",
            'second_length_kavling.required' => "panjang kavling ke dua harap diisi!",
            'area_kavling.required' => "luas kavling harap diisi!",
            'area_building.required' => "luas bangunan harap diisi!",
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
