<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\Filters\WholeJob\Sort;
use App\Http\Services\Searches\Filters\WholeJob\Type;
use App\Http\Services\Searches\HttpSearch;
use App\Models\WholeJob;
use Illuminate\Database\Eloquent\Model;

class WholeJobSearch extends HttpSearch
{

    protected function passable()
    {
        return WholeJob::query();
    }

    protected function filters(): array
    {
        return [
            Type::class,
            Sort::class
        ];
    }

    protected function thenReturn($wholeJobSearch)
    {
        return $wholeJobSearch;
    }
}
