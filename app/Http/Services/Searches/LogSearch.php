<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\Filters\Log\Sort;
use App\Http\Services\Searches\Filters\Log\Search;
use App\Http\Services\Searches\Filters\Log\UserId;
use App\Http\Services\Searches\HttpSearch;
use App\Models\Log;
use Illuminate\Database\Eloquent\Model;

class LogSearch extends HttpSearch
{

    protected function passable()
    {
        return Log::query();
    }

    protected function filters(): array
    {
        return [
            Sort::class,
            UserId::class,
            Search::class
        ];
    }

    protected function thenReturn($logSearch)
    {
        return $logSearch;
    }
}
