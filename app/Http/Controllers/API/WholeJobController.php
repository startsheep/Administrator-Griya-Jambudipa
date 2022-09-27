<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\WholeJobContract;
use App\Http\Requests\wholeJob\CreateWholeJobRequest;
use App\Http\Resources\wholeJob\WholeJobCollection;
use App\Http\Resources\wholeJob\WholeJobDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class WholeJobController extends Controller
{
    protected $wholeJobRepository;

    public function __construct(WholeJobContract $wholeJobRepository)
    {
        $this->wholeJobRepository = $wholeJobRepository;
    }

    public function index(Request $request)
    {
        $result = $this->wholeJobRepository->all($request);

        return new WholeJobCollection($result);
    }

    public function store(CreateWholeJobRequest $request)
    {
        $result = $this->wholeJobRepository->store($request->all());

        $output = $result;
        return response()->json(
            [
                'message' => $output['message'],
                'result' => $output['data'],
                'type' => $output['type'],
            ],
            $output['status']
        );
    }

    public function show($id)
    {
        $result = $this->wholeJobRepository->find($id);

        return new WholeJobDetail($result);
    }

    public function update(CreateWholeJobRequest $request, $id)
    {
        $result = $this->wholeJobRepository->find($id);

        $data = $this->wholeJobRepository->update($request->all(), $result);

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
        $result = $this->wholeJobRepository->find($id);
        $this->wholeJobRepository->delete($result);

        return new WholeJobDetail($result);
    }

    public function payment($id, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'price' => 'required',
        ], [
            'price.require' => 'nominal harap diisi!'
        ]);

        if ($validate->fails()) {
            $response = new JsonResponse([
                'meta' => [
                    'message' => $validate->errors(),
                    'status_code' => 400
                ]
            ], 400);

            throw new ValidationException($validate, $response);
        }

        $result = $this->wholeJobRepository->find($id);
        $this->wholeJobRepository->payment($result, $request->all());

        return new WholeJobDetail($result);
    }
}
