<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\KavlingContract;
use App\Http\Requests\KavlingRequest;
use App\Http\Resources\Kavling\KavlingCollection;
use App\Http\Resources\Kavling\KavlingDetail;
use Illuminate\Http\Request;

class KavlingController extends Controller
{
    protected $kavling;

    public function __construct(KavlingContract $kavling)
    {
        $this->kavling = $kavling;
    }

    public function index(Request $request)
    {
        $result = $this->kavling->all($request);

        return new KavlingCollection($result);
    }

    public function store(KavlingRequest $request)
    {
        $result = $this->kavling->store($request->all());

        return response()->json([
            'message' => 'success',
            'data' => $result
        ]);
    }

    public function show($id)
    {
        $result = $this->kavling->find($id);

        return new KavlingDetail($result);
    }

    public function update(KavlingRequest $request, $id)
    {
        $result = $this->kavling->find($id);

        $data = $this->kavling->update($request->all(), $result);
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
        $result = $this->kavling->find($id);
        $this->kavling->delete($result);

        return new KavlingDetail($result);
    }
}
