<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\Filters\HouseType\Name;
use App\Http\Services\Searches\HttpSearch;
use App\Models\HouseType;
use Illuminate\Database\Eloquent\Model;

class HouseTypeSearch extends HttpSearch
{

    protected function passable()
    {
        return HouseType::with(['kavling']);
    }

    protected function filters(): array
    {
        return [
            Name::class
        ];
    }

    protected function thenReturn($houseTypeSearch)
    {
        return $houseTypeSearch;
    }
}
