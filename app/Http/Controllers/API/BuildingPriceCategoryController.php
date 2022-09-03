<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\BuildingPriceCategoryContract;
use App\Http\Requests\BuildingPriceCategory\BuildingPriceCategoryRequest;
use App\Http\Resources\BuildingPriceCategory\BuildingPriceCategoryCollection;
use App\Http\Resources\BuildingPriceCategory\BuildingPriceCategoryDetail;
use App\Models\BuildingPriceCategory;
use Illuminate\Http\Request;

class BuildingPriceCategoryController extends Controller
{
    protected $buildingPrice;

    public function __construct(BuildingPriceCategoryContract $buildingPrice)
    {
        $this->buildingPrice = $buildingPrice;
    }

    public function index(Request $request)
    {
        $result = $this->buildingPrice->all($request);

        return new BuildingPriceCategoryCollection($result);
    }

    public function store(BuildingPriceCategoryRequest $request)
    {
        $result = $this->buildingPrice->store($request->all());

        return $result;
    }

    public function show($id)
    {
        $result = $this->buildingPrice->find($id);

        return new BuildingPriceCategoryDetail($result);
    }

    public function update(BuildingPriceCategoryRequest $request, $id)
    {
        $result = $this->buildingPrice->find($id);
        $data = $this->buildingPrice->update($request->all(), $result);

        return $data;
    }

    public function delete($id)
    {
        $result = $this->buildingPrice->find($id);
        $this->buildingPrice->delete($result);

        return new BuildingPriceCategoryDetail($result);
    }
}
