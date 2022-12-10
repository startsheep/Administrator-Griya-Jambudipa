<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Position\PositionRepository;
use App\Http\Requests\Position\CreatePositionRequest;
use App\Http\Resources\Position\PositionCollection;
use App\Http\Resources\Position\PositionDetail;
use App\Http\Services\Searches\PositionSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    protected $positionRepository;

    public function __construct(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    public function index(Request $request)
    {
        $factory = app()->make(PositionSearch::class);
        $positions = $factory->apply()->paginate($request->per_page);

        return new PositionCollection($positions);
    }

    public function store(CreatePositionRequest $request)
    {
        $request->merge(['name' => $request->position]);
        return DB::transaction(function () use ($request) {
            return $this->positionRepository->create($request->all());
        });
    }

    public function show($id)
    {
        $position = $this->positionRepository->findOrFail($id);

        return new PositionDetail($position);
    }

    public function update(CreatePositionRequest $request, $id)
    {
        $position = $this->positionRepository->findOrFail($id);

        $request->merge(['name' => $request->position]);
        return DB::transaction(function () use ($request, $position) {
            return $this->positionRepository->update($position->id, $request->all());
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            return $this->positionRepository->delete($id);
        });
    }
}
