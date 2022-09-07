<?php

namespace App\Http\Resources\BasicPrice;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BasicPriceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [];

        foreach ($this as $item) {
            $data[] = [
                "id" => $item->id,
                "parent_id" => $item->parent_id,
                "unit" => $item->unit,
                "amount" => $item->amount,
                "volume" => $item->volume,
                "price" => $item->price,
                "total" => $item->total,
                "description" => $item->description,
                "created_at" => $item->created_at,
                "updated_at" => $item->updated_at,
                "parent" => $item->parent,
                "child" => $item->child,
                "basic_price_category" => $item->basicPriceCategory
            ];
        }

        return $data;
    }
}
