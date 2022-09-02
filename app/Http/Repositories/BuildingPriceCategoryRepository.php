<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\BuildingPriceCategoryContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\BuildingPriceCategorySearch;
use App\Models\BuildingPriceCategory;

class BuildingPriceCategoryRepository implements BuildingPriceCategoryContract
{
    /** @var BuildingPriceCategory */
    protected $category;

    public function __construct(BuildingPriceCategory $category)
    {
        $this->category = $category;
    }

    public function all($request)
    {
        $factory = app()->make(BuildingPriceCategorySearch::class);
        $categories = $factory->apply()->paginate($request->per_page);

        return $categories;
    }

    public function store(array $attributes)
    {
        $result = $this->category->create($attributes);

        return $result;
    }

    public function find($id): BuildingPriceCategory
    {
        return $this->category->with('buildingPrice')->find($id);
    }

    public function update(array $attributes, $result)
    {
        $result->update($attributes);

        return $result;
    }

    public function delete($result)
    {
        if ($result->id != 1) {
            $result->buildingPrice()?->update(['category_id' => 1]);

            return $result->delete();
        }
    }
}
