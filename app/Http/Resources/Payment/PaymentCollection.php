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
            $block = $this->cekBlock($item->customer->customerKavling, $item->kavling->id);
            $reminderPrice = (string) $this->reminderPrice($item->kavling->houseType->price, $item);
            $cekData = $item->customer()
                ->first();

            if ($cekData) {
                if ($reminderPrice != 0) {
                    $result[] = [
                        "id" => $item->id,
                        "reminder_payment" => $reminderPrice,
                        "type" => $item->type,
                        "block" => $item->kavling,
                        "customer" => $item->customer,
                        "documents" => $item->document,
                        "other_develop" => $item->otherDevelop,
                        "created_at" => $item->created_at,
                        "updated_at" => $item->updated_at,
                    ];
                }
            }
        }

        return $result;
    }

    protected function reminderPrice($price, $result)
    {
        $total = 0;

        foreach ($result->paymentPrice as $item) {
            $total += $item->price;
        }

        $price += $result->otherDevelop->develop_price;
        if ($result->discount != null) {
            $price = ($result->discount / 100) * $price;
        }
        $price -= $total;

        return $price;
    }

    protected function cekBlock($result, $id)
    {
        foreach ($result as $item) {
            if ($item->kavling_id == $id) {
                return $item->kavling;
            }
        }
    }
}
