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
        $block = $this->cekBlock($this->customer->customerKavling, $this->kavling->id);
        $reminderPrice = (string) $this->reminderPrice($this->kavling->houseType->price, $this->paymentPrice);
        $cekData = $this->customer()
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->first();

        if ($cekData) {
            if ($reminderPrice != 0) {
                $result  = [
                    "id" => $this->id,
                    "reminder_payment" => $reminderPrice,
                    "type" => $this->type,
                    "block" => $this->kavling,
                    "customer" => $this->customer,
                    "created_at" => $this->created_at,
                    "updated_at" => $this->updated_at,
                ];
            }
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

    protected function reminderPrice($price, $result)
    {
        $total = 0;
        foreach ($result as $item) {
            $total += $item->price;
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
