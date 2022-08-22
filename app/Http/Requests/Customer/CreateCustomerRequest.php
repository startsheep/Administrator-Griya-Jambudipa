<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CreateCustomerRequest extends FormRequest
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
            'kavlings' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'profession' => 'required',
            'gender' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kavlings.required' => "kavling harap diisi!",
            'name.required' => "nama harap diisi!",
            'phone.required' => "telepon harap diisi!",
            'phone.numeric' => "telepon harap diisi dengan angka!",
            'gender.required' => "jenis kelamin harap diisi!",
            'address.required' => "alamat harap diisi!",
            'profession.required' => "pekerjaan harap diisi!",
            'email.required' => ":attribute harap diisi!",
            'email.email' => "Harap masukan :attribute yang benar!",
            'image.required' => "gambar harap diisi!",
            'image.image' => "harap masukan tipe data gambar!",
            'image.mimes' => "harap masukan tipe data png, jpg, jpeg!",
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
