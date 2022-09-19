<?php

namespace App\Http\Services\Searches;

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
        return [];
    }

    protected function thenReturn($wholeJobSearch)
    {
        return $wholeJobSearch;
    }
}
