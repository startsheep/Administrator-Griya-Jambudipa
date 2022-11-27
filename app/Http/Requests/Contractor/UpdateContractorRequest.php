<?php

namespace App\Http\Requests\Contractor;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateContractorRequest extends FormRequest
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
        $data = [
            'company_name' => 'required',
            'phone' => ['required', 'numeric', Rule::unique('contractors')->ignore(request('id'))],
            'email' => ['required', 'email', Rule::unique('contractors')->ignore(request('id'))],
            'address' => 'required',
            'pic_name' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg|max:5000',
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'company_name.required' => "nama perusahaan harap diisi!",
            'phone.required' => "no telepon harap diisi!",
            'phone.numeric' => "no telepon harap diisi dengan angka!",
            'email.required' => ":attribute harap diisi!",
            'email.email' => "harap masukan :attribute valid!",
            'email.unique' => ":attribute sudah terdaftar!",
            'address.required' => "alamat harap diisi!",
            'pic_name.required' => "nama pic harap diisi!",
            'image.image' => "harap masukan tipe data gambar!",
            'image.mimes' => "harap masukan tipe data png, jpg, jpeg!",
            'image.max' => "ukuran file maksimal :max MB"
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
