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
        // $result = [];

        // foreach ($this as $item) {
        //     $priceHouseType = $this->priceHouseType($item->customer->customerKavling);

        //     $result[] = [
        //         "id" => $item->id,
        //         "customer_id" => $item->customer_id,
        //         "price" => $item->price,
        //         "created_at" => $item->created_at,
        //         "updated_at" => $item->updated_at,
        //         "price_house" => $priceHouseType
        //     ];
        // }

        return parent::toArray($request);
    }

    protected function priceHouseType($result)
    {
        // $price = "";

        // foreach ($result as $item) {

        //     $price = $item->kavling->houseType->price;
        // }

        return $result;
    }
}
