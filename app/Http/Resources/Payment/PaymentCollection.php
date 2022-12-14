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
            $reminderPrice = (string) $this->reminderPrice($item->kavling->houseType->price, $item);
            $totalCost = (string) $this->totalCost($item->kavling->houseType->price, $item);
            $cekData = $item->customer()->first();

            if ($cekData) {
                if ($reminderPrice != 0) {
                    $result[] = [
                        "id" => $item->id,
                        "reminder_payment" => $reminderPrice,
                        "total_cost" => $totalCost,
                        "type" => $item->type,
                        "block" => $item->kavling,
                        "house_type" => $item->kavling->house_type,
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

    protected function totalCost($priceHouse, $result)
    {
        $discount = 0;
        $total = $priceHouse;
        if ($result->otherDevelop) {
            // dd($result->otherDevelop);
            $total += $result->otherDevelop?->develop_price;
        }

        if ($result->discount != null) {
            $discount = ($result->discount / 100) * $total;
        }
        $total -= $discount;
        return $total;
    }

    protected function reminderPrice($price, $result)
    {
        $total = 0;

        foreach ($result->paymentPrice as $item) {
            $total += $item->price;
        }

        if ($result->otherDevelop) {
            $price += $result->otherDevelop->develop_price;
        }
        $discount = 0;
        if ($result->discount != null) {
            $discount = ($result->discount / 100) * $price;
        }
        $price -= $total + $discount;

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
