<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\BasicPriceCategoryContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\BasicPriceCategorySearch;
use App\Imports\BasicCategoryPriceImport;
use App\Models\BasicPriceCategory;
use App\Models\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan penambahan data pada harga dasar ' . request('section')
        ]);

        return $result;
    }

    public function import(array $attributes)
    {
        $result = Excel::import(new BasicCategoryPriceImport, $attributes['file']);

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan import data excel pada harga dasar ' . request('section')
        ]);

        return $result;
    }

    public function find($id): BasicPriceCategory
    {
        return $this->category->with('basicPrice')->findOrFail($id);
    }

    public function update(array $attributes, $result)
    {
        $result->update($attributes);

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan perubahan data pada harga dasar ' . $result->section
        ]);

        return $result;
    }

    public function delete($result)
    {
        if ($result->id != 1) {
            $result->basicPrice()?->update(['basic_price_category_id' => 1]);

            return $result->delete();
        }
    }
}
