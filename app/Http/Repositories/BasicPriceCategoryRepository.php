<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\BasicPriceCategoryContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\BasicPriceCategorySearch;
use App\Models\BasicPriceCategory;

class BasicPriceCategoryRepository implements BasicPriceCategoryContract
{
    /** @var BasicPriceCategory */
    protected $category;

    public function __construct(BasicPriceCategory $category)
    {
        $this->category = $category;
    }

    public function all($request)
    {
        $factory = app()->make(BasicPriceCategorySearch::class);
        $categories = $factory->apply()->with(['basicPrice.child'])->paginate($request->per_page);

        return $categories;
    }

    public function store(array $attributes)
    {
        $result = $this->category->create($attributes);

        return $result;
    }

    public function find($id): BasicPriceCategory
    {
        return $this->category->with('basicPrice')->findOrFail($id);
    }

    public function update(array $attributes, $result)
    {
        $result->update($attributes);

        return $result;
    }

    public function delete($result)
    {
        foreach ($result->basicPrice as $basicPrice) {
            $basicPrice->child()->delete();
        }
        $result->basicPrice()->delete();
        return $result->delete();
    }
}
