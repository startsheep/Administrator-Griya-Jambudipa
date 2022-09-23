<?php

namespace App\Http\Services\Searches;

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
        return [];
    }

    protected function thenReturn($logSearch)
    {
        return $logSearch;
    }
}
