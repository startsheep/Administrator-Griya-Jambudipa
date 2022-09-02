<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\BuildingPriceContract;
use App\Http\Requests\BuildingPrice\BuildingPriceRequest;
use App\Http\Resources\BuildingPrice\BuildingPriceCollection;
use App\Http\Resources\BuildingPrice\BuildingPriceDetail;
use App\Models\BuildingPrice;
use Illuminate\Http\Request;

class BuildingPriceController extends Controller
{
    protected $buildingPrice;

    public function __construct(BuildingPriceContract $buildingPrice)
    {
        $this->buildingPrice = $buildingPrice;
    }

    public function index(Request $request)
    {
        $result = $this->buildingPrice->all($request);

        return new BuildingPriceCollection($result);
    }

    public function store(BuildingPriceRequest $request)
    {
        $result = $this->buildingPrice->store($request->all());

        return $result;
    }

    public function show($id)
    {
        $result = $this->buildingPrice->find($id);

        return new BuildingPriceDetail($result);
    }

    public function update(BuildingPriceRequest $request, $id)
    {
        $result = $this->buildingPrice->find($id);
        $data = $this->buildingPrice->update($request->all(), $result);

        return $data;
    }

    public function delete($id)
    {
        $result = $this->buildingPrice->find($id);
        $this->buildingPrice->delete($result);

        return new BuildingPriceDetail($result);
        // hello
    }
}
