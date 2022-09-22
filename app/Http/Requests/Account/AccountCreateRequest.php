<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AccountCreateRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "nama harap diisi!",
            'phone.required' => "telepon harap diisi!",
            'phone.numeric' => "telepon harap diisi dengan angka!",
            'email.required' => ":attribute harap diisi!",
            'email.email' => "Harap masukan :attribute yang benar!",
            'email.unique' => "email sudah terdaftar!",
            'image.required' => "gambar harap diisi!",
            'image.image' => "harap masukan tipe data gambar!",
            'image.mimes' => "harap masukan tipe data png, jpg, jpeg!",
            'image.max' => "ukuran file maksimal :max MB",
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
