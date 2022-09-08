<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\BasicPriceContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\BasicPriceSearch;
use App\Models\BasicPrice;
use Illuminate\Support\Collection;

class BasicPriceRepository implements BasicPriceContract
{
    /** @var BasicPrice */
    protected $basicPrice;

    public function __construct(BasicPrice $basicPrice)
    {
        $this->basicPrice = $basicPrice;
    }

    public function all($request)
    {
        $factory = app()->make(BasicPriceSearch::class);
        $basicPrices = $factory->apply()->paginate($request->per_page);

        return $basicPrices;
    }

    public function store(array $attributes)
    {
        // print_r($attributes);
        // die();

        $result = $this->basicPrice->create($attributes);

        return $result;
    }

    public function find($id): BasicPrice
    {
        return $this->basicPrice->with(['parent', 'child', 'basicPriceCategory'])->findOrFail($id);
    }

    public function update(array $attributes, $result)
    {
        $result->update($attributes);

        return $result;
    }

    public function delete($result)
    {
        if ($result->parent_id == null) {
            $this->basicPrice->where('parent_id', $result->id)->delete();
        }

        return $result->delete();
    }
}
