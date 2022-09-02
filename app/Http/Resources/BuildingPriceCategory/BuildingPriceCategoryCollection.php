<?php

namespace App\Http\Resources\BuildingPriceCategory;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BuildingPriceCategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = array();

        foreach ($this as $item) {
            $data[] = [
                "id" => $item->id,
                "category" => $item->category,
                "created_at" => $item->created_at,
                "updated_at" => $item->updated_at,
                "building_price" => $item->buildingPrice ? $item->buildingPrice : null,
            ];
        }

        return $data;
    }
}
