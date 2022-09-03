<?php

namespace App\Http\Resources\BuildingPrice;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BuildingPriceCollection extends ResourceCollection
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
                "building_price_category_id" => $item->building_price_category_id,
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
                "building_price_category" => $item->buildingPriceCategory
            ];
        }

        return $data;
    }
}
