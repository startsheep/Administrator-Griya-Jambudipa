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
            $price = (string) $this->priceHouseType($item->customer->customerKavling);
            $reminderPrice = (string) $this->reminderPrice($price, $item->paymentPrice);
            $cekData = $item->customer()
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->first();

            if ($cekData) {
                if ($reminderPrice != 0) {
                    $result[] = [
                        "id" => $item->id,
                        "reminder_payment" => $reminderPrice,
                        "price_house" => $price,
                        "type" => $item->type,
                        "customer" => $item->customer,
                        "created_at" => $item->created_at,
                        "updated_at" => $item->updated_at,
                    ];
                }
            }
        }

        return $result;
        // return parent::toArray($request);
    }

    protected function priceHouseType($result)
    {
        $price = 0;

        foreach ($result as $item) {
            $price += $item->kavling->houseType->price;
        }
        return $price;
    }

    protected function reminderPrice($price, $result)
    {
        $total = 0;

        foreach ($result as $item) {
            $total += $item->price;
        }

        $price -= $total;

        return $price;
    }
}
