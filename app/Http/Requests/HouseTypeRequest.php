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
        $request = [
            'house_type' => 'required',
            'description' => 'required',
            'price' => 'required'
        ];

        if (request()->images) {
            $request['images'] = 'max:5000';
        }

        return $request;
    }

    public function messages()
    {
        return [
            'house_type.required' => "tipe rumah harap diisi!",
            'description.required' => "keterangan harap diisi!",
            'price.required' => "harga harap diisi!",
            'images.max' => "ukuran file maksimal :max MB"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $result = new JsonResponse([
            'meta' => [
                'message' => $validator->errors(),
                'status_code' => 400
            ]
        ], 400);

        throw new ValidationException($validator, $result);
    }
}
