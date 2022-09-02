<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\BuildingPriceContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\BuildingPriceSearch;
use App\Models\BuildingPrice;
use Illuminate\Support\Collection;

class BuildingPriceRepository implements BuildingPriceContract
{
    /** @var BuildingPrice */
    protected $buildingPrice;

    public function __construct(BuildingPrice $buildingPrice)
    {
        $this->buildingPrice = $buildingPrice;
    }

    public function all($request)
    {
        $factory = app()->make(BuildingPriceSearch::class);
        $buildingPrices = $factory->apply()->paginate($request->per_page);

        return $buildingPrices;
    }

    public function store(array $attributes)
    {
        $result = $this->buildingPrice->create($attributes);

        return $result;
    }

    public function find($id): BuildingPrice
    {
        return $this->buildingPrice->find($id);
    }

    public function update(array $attributes, $result)
    {
        $result->update($attributes);

        return $result;
    }

    public function delete($result)
    {
        if ($result->parent_id == null) {
            $this->buildingPrice->where('parent_id', $result->id)->delete();
        }

        return $result->delete();
    }
}
