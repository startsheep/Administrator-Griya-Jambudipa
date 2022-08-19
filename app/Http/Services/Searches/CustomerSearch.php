<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\Filters\Customer\Block;
use App\Http\Services\Searches\Filters\Customer\Name;
use App\Http\Services\Searches\Filters\Customer\Phone;
use App\Http\Services\Searches\Filters\Customer\Sort;
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
        return [
            Name::class,
            Phone::class,
            Sort::class,
            Block::class
        ];
    }

    protected function thenReturn($customerSearch)
    {
        return $customerSearch;
    }
}
