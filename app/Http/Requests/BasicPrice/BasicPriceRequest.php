<?php

namespace App\Http\Requests\BasicPrice;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BasicPriceRequest extends FormRequest
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
        if (isset(request()->parent_id) && request()->parent_id == "") {
            $data['parent_id'] = 'required|exists:basic_prices,id';
        }

        if (isset(request()->unit) && request()->unit == "") {
            $data['unit'] = 'required';
        }

        if (isset(request()->amount) && request()->amount == "") {
            $data['amount'] = 'required';
        }

        if (isset(request()->volume) && request()->volume == "") {
            $data['volume'] = 'required';
        }

        if (isset(request()->price) && request()->price == "") {
            $data['price'] = 'required';
        }

        if (isset(request()->total) && request()->total == "") {
            $data['total'] = 'required';
        }

        $data['description'] = 'required';

        return $data;
    }

    public function messages()
    {
        return [
            'description.required' => "uraian harap diisi!",
            'unit.required' => "satuan harap diisi!",
            'amount.required' => "jumlah harap diisi!",
            'volume.required' => "volume harap diisi!",
            'price.required' => "harga harap diisi!",
            'total.required' => "total harap diisi!",
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
