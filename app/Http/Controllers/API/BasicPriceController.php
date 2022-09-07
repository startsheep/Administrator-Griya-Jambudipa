<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\BasicPriceContract;
use App\Http\Requests\BasicPrice\BasicPriceRequest;
use App\Http\Resources\BasicPrice\BasicPriceCollection;
use App\Http\Resources\BasicPrice\BasicPriceDetail;
use Illuminate\Http\Request;

class BasicPriceController extends Controller
{
    protected $basicPrice;

    public function __construct(BasicPriceContract $basicPrice)
    {
        $this->basicPrice = $basicPrice;
    }

    public function index(Request $request)
    {
        $result = $this->basicPrice->all($request);

        return new BasicPriceCollection($result);
    }

    public function store(BasicPriceRequest $request)
    {
        $result = $this->basicPrice->store($request->all());

        return $result;
    }

    public function show($id)
    {
        $result = $this->basicPrice->find($id);

        return new BasicPriceDetail($result);
    }

    public function update(BasicPriceRequest $request, $id)
    {
        $result = $this->basicPrice->find($id);
        $data = $this->basicPrice->update($request->all(), $result);

        return $data;
    }

    public function delete($id)
    {
        $result = $this->basicPrice->find($id);
        $this->basicPrice->delete($result);

        return new BasicPriceDetail($result);
    }
}
