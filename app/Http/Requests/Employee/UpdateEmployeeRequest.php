<?php

namespace App\Http\Requests\Employee;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateEmployeeRequest extends FormRequest
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
            'position_id' => [
                'required',
                Rule::exists('positions', 'id')
            ],
            'name' => [
                'required'
            ],
            'email' => [
                'email',
                'required',
            ],
            'phone' => [
                'required',
                'numeric'
            ],
            'gender' => [
                'required'
            ],
            'address' => [
                'required'
            ],
            'entry_date' => [
                'required',
            ],

        ];
    }

    public function messages()
    {
        return [
            'position_id.required' => "jabatan harap diisi!",
            'position_id.exists' => "jabatan tidak terdaftar!",
            'name.required' => "nama harap diisi!",
            'phone.required' => "telepon harap diisi!",
            'phone.numeric' => "telepon harap diisi dengan angka!",
            'gender.required' => "jenis kelamin harap diisi!",
            'address.required' => "alamat harap diisi!",
            'entry_date.required' => "tanggal masuk harap diisi!",


            'email.required' => ":attribute harap diisi!",
            'email.email' => "harap masukan :attribute yang benar!",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'meta' => [
                'message' => $validator->errors(),
                'status_code' => 400
            ]
        ], 400);

        throw new ValidationException($validator, $response);
    }
}
