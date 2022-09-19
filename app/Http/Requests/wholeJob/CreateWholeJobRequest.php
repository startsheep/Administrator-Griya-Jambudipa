<?php

namespace App\Http\Requests\wholeJob;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CreateWholeJobRequest extends FormRequest
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
        $request = [
            'contractor_id' => 'required|exists:contractors,id',
            'customer_id' => 'required|exists:customers,id',
            'house_type_id' => 'required|exists:house_types,id',
            'payment_type' => 'required',
            'description' => 'required',
            'total_cost' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        if (isset(request()->documents)) {
            $request['documents'] = 'required';
        }

        return $request;
    }

    public function messages()
    {
        return [
            'contractor_id.required' => 'pemborong harap diisi!',
            'contractor_id.exist' => 'pemborong tidak terdaftar!',
            'customer_id.required' => 'customer harap diisi!',
            'customer_id.exist' => 'customer tidak terdaftar!',
            'house_type_id.required' => 'tipe rumah harap diisi!',
            'house_type_id.exist' => 'tipe rumah tidak terdaftar!',
            'payment_type.required' => 'tipe pembayaran harap diisi!',
            'description.required' => 'deskripsi harap diisi!',
            'total_cost.required' => 'total biaya harap diisi!',
            'start_date.required' => 'tanggal mulai harap diisi!',
            'end_date.required' => 'tanggal selesai harap diisi!',
            'documents.required' => 'dokumen harap diisi!',
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
