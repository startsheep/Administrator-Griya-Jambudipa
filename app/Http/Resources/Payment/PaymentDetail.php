<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            "id" => $this->id,
            "customer_id" => $this->customer_id,
            "price" => $this->price,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "price_house" => (string) $this->priceHouseType($this->customer->customerKavling)
        ];

        return $result;
    }

    protected function priceHouseType($result)
    {
        $price = 0;

        foreach ($result as $item) {
            $price += $item->kavling->houseType->price;
        }

        return $price;
    }
}
