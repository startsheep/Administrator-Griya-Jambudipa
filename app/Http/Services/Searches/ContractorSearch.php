<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\Filters\Contractor\CompanyName;
use App\Http\Services\Searches\HttpSearch;
use App\Http\Serviceses\Filters\Contractor\Search;
use App\Models\Contractor;
use Illuminate\Database\Eloquent\Model;

class ContractorSearch extends HttpSearch
{
    protected function passable()
    {
        return Contractor::query();
    }

    protected function filters(): array
    {
        return [
            CompanyName::class
        ];
    }

    protected function thenReturn($contractorSearch)
    {
        return $contractorSearch;
    }
}
