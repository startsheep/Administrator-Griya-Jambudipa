<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\HttpSearch;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class CustomerSearch extends HttpSearch
{

    protected function passable()
    {
        return Customer::query();
    }

    protected function filters(): array
    {
        return [];
    }

    protected function thenReturn($customerSearch)
    {
        return $customerSearch;
    }
}
