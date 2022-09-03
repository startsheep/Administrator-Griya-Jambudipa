<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\HttpSearch;
use App\Models\BuildingPriceCategory;
use Illuminate\Database\Eloquent\Model;

class BuildingPriceCategorySearch extends HttpSearch
{

    protected function passable()
    {
        return BuildingPriceCategory::query();
    }

    protected function filters(): array
    {
        return [];
    }

    protected function thenReturn($buildingPriceCategorySearch)
    {
        return $buildingPriceCategorySearch;
    }
}
