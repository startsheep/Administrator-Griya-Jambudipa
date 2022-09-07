<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\HttpSearch;
use App\Models\BasicPrice;
use Illuminate\Database\Eloquent\Model;

class BasicPriceSearch extends HttpSearch
{

    protected function passable()
    {
        return BasicPrice::query();
    }

    protected function filters(): array
    {
        return [];
    }

    protected function thenReturn($basicPriceSearch)
    {
        return $basicPriceSearch;
    }
}
