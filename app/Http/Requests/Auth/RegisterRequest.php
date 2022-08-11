<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
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
            'name' => [
                'required',
                'string'
            ],
            'email' => [
                'email',
                'unique:users,email',
                'required'
            ],
            'password' => [
                'min:8',
                'max:255',
                'required',
                'same:confirm_password',
                'required_with:confirm_password',
            ],
            'confirm_password' => [
                'min:8',
                'max:255',
                'required',
                'same:password'
            ],
            'image' => [
                'image',
                'required',
                'mimes:png,jpg,jpeg'
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'meta' => [
                'message' => $validator->errors(),
                'status_code' => 400
            ]
        ]);

        throw new ValidationException($validator, $response);
    }
}
