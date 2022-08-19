<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\HouseTypeContract;
use App\Http\Requests\HouseTypeRequest;
use App\Http\Resources\HouseType\HouseTypeCollection;
use App\Http\Resources\HouseType\HouseTypeDetail;
use Illuminate\Http\Request;

class HouseTypeController extends Controller
{
    protected $houseType;

    public function __construct(HouseTypeContract $houseType)
    {
        $this->houseType = $houseType;
    }

    public function index(Request $request)
    {
        $result = $this->houseType->all($request);

        return new HouseTypeCollection($result);
    }

    public function store(HouseTypeRequest $request)
    {
        $result = $this->houseType->store($request->all());

        return response()->json([
            'message' => 'success',
            'data' => $result
        ]);
    }

    public function show($id)
    {
        $result = $this->houseType->find($id);

        return new HouseTypeDetail($result);
    }

    public function update(HouseTypeRequest $request, $id)
    {
        $result = $this->houseType->find($id);

        $data = $this->houseType->update($request->all(), $result);
        $output = $data;
        return response()->json(
            [
                'message' => $output['message'],
                'type' => $output['type'],
                'result' => $output['data']
            ],
            $output['status']
        );
    }

    public function delete($id)
    {
        $result = $this->houseType->find($id);
        $this->houseType->delete($result);

        return new HouseTypeDetail($result);
    }
}
