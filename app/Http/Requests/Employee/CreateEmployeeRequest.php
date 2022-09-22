<?php

namespace App\Http\Requests\Employee;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateEmployeeRequest extends FormRequest
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
                'unique:employees,email'
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
            'image' => [
                'required',
                'image',
                'mimes:png,jpg,jpeg',
                'max:5000'
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
            'image.required' => "gambar harap diisi!",
            'image.image' => "harap masukan tipe data gambar!",
            'image.mimes' => "harap masukan tipe data png, jpg, jpeg!",
            'image.max' => "ukuran file maksimal :max MB",
            'email.required' => ":attribute harap diisi!",
            'email.email' => "harap masukan :attribute yang benar!",
            'email.unique' => ":attribute sudah terdaftar!",
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
