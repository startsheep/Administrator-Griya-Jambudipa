<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ChangePasswordRequest extends FormRequest
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
            'password' => 'required|same:confirm_password|min:8|max:255',
            'confirm_password' => 'required|same:password|min:8|max:255',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => ":attribute harap diisi!",
            'password.min' => ":attribute minimal :min!",
            'password.max' => ":attribute maksimal :max!",
            'password.same' => "password harus sama dengan konfirmasi password!",
            'confirm_password.required' => "konfirmasi password harap diisi!",
            'confirm_password.min' => "konfirmasi password minimal :min!",
            'confirm_password.max' => "konfirmasi password maksimal :max!",
            'confirm_password.same' => "konfirmasi password harus sama dengan password!",
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
