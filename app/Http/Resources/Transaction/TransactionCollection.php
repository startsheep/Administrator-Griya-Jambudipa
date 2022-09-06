<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
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
            $reminderPrice = (string) $this->reminderPrice($item->houseType->price, $item->paymentPrice);
            $cekData = $item->customer()
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->first();

            if ($cekData) {
                if ($reminderPrice == 0) {
                    $result[] = [
                        "id" => $item->id,
                        "reminder_payment" => $reminderPrice,
                        "house_type" => $item->houseType,
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
