<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AccountUpdateRequest extends FormRequest
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
        if (empty(request()->image)) {
            $request = [
                'name' => 'required',
                'email' => [
                    'email',
                    'required',
                    Rule::unique('users')->ignore(request('id'))
                ],
                'phone' => 'required|numeric',
            ];
        }

        if (!empty(request()->image)) {
            $request['image'] = 'image|mimes:png,jpg,jpeg|max:5000';
        }

        return $request;
    }

    public function messages()
    {
        return [
            'name.required' => "nama harap diisi!",
            'phone.required' => "telepon harap diisi!",
            'phone.numeric' => "telepon harap diisi dengan angka!",
            'email.email' => "Harap masukan :attribute yang benar!",
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
