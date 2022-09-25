<?php

namespace App\Http\Resources\Log;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LogCollection extends ResourceCollection
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
            $item->user->image;
            $result[] = [
                "id" => $item->id,
                "user_id" => $item->user_id,
                "description" => $item->description,
                "created_at_id" => Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->diffForHumans(),
                "created_at" => $item->created_at,
                "updated_at" => $item->updated_at,
                "user" => $item->user,
            ];
        }

        // return parent::toArray($request);
        return $result;
    }
}
