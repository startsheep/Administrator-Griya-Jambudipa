<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class NewPasswordRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'password' => [
                'required',
                'min:8'
            ],
            'password_confirmation' => [
                'required',
                'min:8',
                'same:password'
            ],
            'email' => [
                'required',
                'email',
                'exists:users,email',
            ],
            'token' => [
                'required'
            ]
        ];
    }

    public function messages()
    {
        return [
            'password.required' => ":attribute harap diisi!",
            'password.min' => ":attribute minimal :min!",
            'password_confirmation.required' => "konfirmasi password harap diisi!",
            'password_confirmation.min' => "konfirmasi password minimal :min!",
            'password_confirmation.same' => "konfirmasi password tidak sama dengan password!",
            'email.required' => ":attribute harap diisi!",
            'email.email' => "Harap masukan :attribute yang benar!",
            'email.exists' => ":atttibute tidak terdaftar!",
            'token.required' => ":attribute harap diisi!",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'meta' => [
                'message' => $validator->errors(),
                'status_code' => 400,
            ]
        ], 400);

        throw new ValidationException($validator, $response);
    }
}
