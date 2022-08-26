<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\KavlingContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\KavlingSearch;
use App\Models\Kavling;

class KavlingRepository implements KavlingContract
{
    /** @var Kavling */
    protected $kavling;

    public function __construct(Kavling $kavling)
    {
        $this->kavling = $kavling;
    }

    public function all($request)
    {
        $factory = app()->make(KavlingSearch::class);
        $kavlings = $factory->apply()->with('houseType')->paginate($request->per_page);

        return $kavlings;
    }

    public function store(array $attributes): Kavling
    {
        return $this->kavling->create($attributes);
    }

    public function find($id): Kavling
    {
        return $this->kavling->with('houseType')->find($id);
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
