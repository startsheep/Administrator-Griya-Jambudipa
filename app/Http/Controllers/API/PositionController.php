<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\PositionContract;
use App\Http\Repositories\PositionRepository;
use App\Http\Requests\Position\CreatePositionRequest;
use App\Http\Resources\Position\PositionCollection;
use App\Http\Resources\Position\PositionDetail;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    protected $positionRepository;

    public function __construct(PositionContract $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    public function index(Request $request)
    {
        $result = $this->positionRepository->all($request);

        return $result;
    }

    public function store(CreatePositionRequest $request)
    {
        return $this->positionRepository->store($request->all());
    }

    public function show($id)
    {
        $result = $this->positionRepository->find($id);

        return new PositionDetail($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->positionRepository->find($id);

        $data = $this->positionRepository->update($request->all(), $result);
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
        $result = $this->positionRepository->find($id);
        $this->positionRepository->delete($result);

        return new PositionDetail($result);
    }
}
