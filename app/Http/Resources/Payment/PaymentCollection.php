<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [];

        foreach ($this as $item) {
            // $price = (string) $this->priceHouseType($item->customer->customerKavling);

            $result[] = [
                "id" => $item->id,
                "customer_id" => $item->customer_id,
                "price" => $item->price,
                "created_at" => $item->created_at,
                "updated_at" => $item->updated_at,
                // "reminder_payment" => (string) ($price - $item->price),
                // "price_house" => $price
            ];
        }

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
