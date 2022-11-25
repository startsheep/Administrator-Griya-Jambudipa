<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\BasicPriceCategoryContract;
use App\Http\Requests\BasicPriceCategory\BasicPriceCategoryRequest;
use App\Http\Requests\ImportRequest;
use App\Http\Resources\BasicPriceCategory\BasicPriceCategoryCollection;
use App\Http\Resources\BasicPriceCategory\BasicPriceCategoryDetail;
use Illuminate\Http\Request;

class BasicPriceCategoryController extends Controller
{
    protected $buildingPrice;

    public function __construct(BasicPriceCategoryContract $buildingPrice)
    {
        $this->buildingPrice = $buildingPrice;
    }

    public function index(Request $request)
    {
        $result = $this->buildingPrice->all($request);

        return new BasicPriceCategoryCollection($result);
    }

    public function store(BasicPriceCategoryRequest $request)
    {
        $result = $this->buildingPrice->store($request->all());

        return $result;
    }

    public function import(ImportRequest $request)
    {
        $result = $this->buildingPrice->import($request->all());

        return $result;
    }

    public function show($id)
    {
        $result = $this->buildingPrice->find($id);

        return new BasicPriceCategoryDetail($result);
    }

    public function update(BasicPriceCategoryRequest $request, $id)
    {
        $result = $this->buildingPrice->find($id);
        $data = $this->buildingPrice->update($request->all(), $result);

        return $data;
    }

    public function delete($id)
    {
        $result = $this->buildingPrice->find($id);
        $this->buildingPrice->delete($result);

        return new BasicPriceCategoryDetail($result);
    }
}
