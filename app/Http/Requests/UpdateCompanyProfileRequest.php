<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UpdateCompanyProfileRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'url' => 'required',
            'address' => 'required',
            'logo' => 'image|mimes:png,jpg,jpeg|max:5000',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ":attribute harap diisi!",
            'email.email' => "Harap masukan :attribute yang benar!",
            'name.required' => "nama harap diisi!",
            'phone.required' => "telepon harap diisi!",
            'phone.numeric' => "telepon harap diisi dengan angka!",
            'url.required' => ":attribute harap diisi!",
            'address.required' => "alamat harap diisi!",
            'logo.image' => "harap masukan tipe data gambar!",
            'logo.mimes' => "harap masukan tipe data png, jpg, jpeg!",
            'logo.max' => "ukuran gambar maksimal :max MB"
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
