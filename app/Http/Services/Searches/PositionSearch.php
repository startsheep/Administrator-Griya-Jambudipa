<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\Filters\Position\Name;
use App\Http\Services\Searches\Filters\Position\Sort;
use App\Http\Services\Searches\HttpSearch;
use App\Models\Position;
use Illuminate\Database\Eloquent\Model;

class PositionSearch extends HttpSearch
{

    protected function passable()
    {
        return Position::query();
    }

    protected function filters(): array
    {
        return [
            Name::class,
            Sort::class
        ];
    }

    protected function thenReturn($positionSearch)
    {
        return $positionSearch;
    }
}
