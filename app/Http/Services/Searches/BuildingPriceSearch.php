<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\HttpSearch;
use App\Models\BuildingPrice;
use Illuminate\Database\Eloquent\Model;

class BuildingPriceSearch extends HttpSearch
{

 	protected function passable()
	{
		return BuildingPrice::query();
	}

	protected function filters(): array
	{
		return [

		];
	}

	protected function thenReturn($buildingPriceSearch)
	{
		return $buildingPriceSearch;
	}
}
