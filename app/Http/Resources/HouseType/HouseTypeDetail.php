<?php

namespace App\Http\Resources\HouseType;

use Illuminate\Http\Resources\Json\JsonResource;

class HouseTypeDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->load('kavling');
        return parent::toArray($request);
    }
}
