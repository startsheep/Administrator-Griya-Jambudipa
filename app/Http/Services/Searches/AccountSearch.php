<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\Filters\Account\Name;
use App\Http\Services\Searches\Filters\Account\Sort;
use App\Http\Services\Searches\HttpSearch;
use App\Models\Account;
use Illuminate\Database\Eloquent\Model;

class AccountSearch extends HttpSearch
{

    protected function passable()
    {
        return Account::query();
    }

    protected function filters(): array
    {
        return [
            Name::class,
            Sort::class
        ];
    }

    protected function thenReturn($accountSearch)
    {
        return $accountSearch;
    }
}
