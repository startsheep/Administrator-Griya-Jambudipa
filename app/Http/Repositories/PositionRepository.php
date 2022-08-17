<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\PositionContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\PositionSearch;
use App\Models\Position;
use Illuminate\Support\Collection;
use DataTables;

class PositionRepository implements PositionContract
{
    /** @var Position */
    protected $position;

    public function __construct(Position $position)
    {
        $this->position = $position;
    }

    public function all($request)
    {
        // $factory = app()->make(PositionSearch::class);
        // $positions = $factory->apply()->paginate($request->per_page);
        $result = $this->position->all();
        $positions = DataTables::of($result)
            ->addIndexColumn()
            ->make(true);

        return $positions;
    }

    public function store(array $attributes): Position
    {
        $attributes['name'] = $attributes['position'];
        return $this->position->create($attributes);
    }

    public function find($id): Position
    {
        return $this->position->find($id);
    }

    public function update(array $attributes, $result)
    {
        $attributes['name'] = $attributes['position'];
        $result->update($attributes);

        return collect([
            'message' => "success",
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function delete($result)
    {
        return $result->delete();
    }
}