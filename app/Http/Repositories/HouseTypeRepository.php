<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\HouseTypeContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\HouseTypeSearch;
use App\Models\HouseType;

class HouseTypeRepository implements HouseTypeContract
{
    /** @var HouseType */
    protected $houseType;

    public function __construct(HouseType $houseType)
    {
        $this->houseType = $houseType;
    }

    public function all($request)
    {
        $factory = app()->make(HouseTypeSearch::class);
        $houseTypes = $factory->apply()->paginate($request->per_page);

        return $houseTypes;
    }

    public function store(array $attributes): HouseType
    {
        return $this->houseType->create($attributes);
    }

    public function find($id): HouseType
    {
        return $this->houseType->find($id);
    }

    public function update(array $attributes, $result)
    {
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
