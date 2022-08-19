<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\HttpSearch;
use App\Models\Kavling;
use Illuminate\Database\Eloquent\Model;

class KavlingSearch extends HttpSearch
{

    protected function passable()
    {
        return Kavling::query();
    }

    protected function filters(): array
    {
        return [];
    }

    protected function thenReturn($kavlingSearch)
    {
        return $kavlingSearch;
    }
}
