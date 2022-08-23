<?php

namespace App\Http\Services\Searches;

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
        return [];
    }

    protected function thenReturn($accountSearch)
    {
        return $accountSearch;
    }
}
