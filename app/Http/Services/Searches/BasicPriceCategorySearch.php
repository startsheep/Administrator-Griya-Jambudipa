<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\Filters\BasicPriceCategory\Search;
use App\Http\Services\Searches\Filters\BasicPriceCategory\Section;
use App\Http\Services\Searches\HttpSearch;
use App\Models\BasicPriceCategory;
use Illuminate\Database\Eloquent\Model;

class BasicPriceCategorySearch extends HttpSearch
{

    protected function passable()
    {
        return BasicPriceCategory::query();
    }

    protected function filters(): array
    {
        return [
            Search::class,
            Section::class
        ];
    }

    protected function thenReturn($basicPriceCategorySearch)
    {
        return $basicPriceCategorySearch;
    }
}
