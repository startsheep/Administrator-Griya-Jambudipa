<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
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
        $id = 0;
        if(request()->id){
            $id = request()->id;
        }
        $request = [
            'kavling_id' => [
                'required',
                'exists:kavlings,id',
                Rule::unique('house_types')->ignore($id)
            ],
            'description' => 'required',
            'price' => 'required'
        ];

        if (request()->images) {
            $request['images'] = 'required|max:5000';
        }

        return $request;
    }

    public function messages()
    {
        return [
            'kavling_id.required' => 'Kavling harus diisi',
            'kavling_id.unique' => 'Kavling sudah terdaftar',
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
