<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\Filters\Employee\Active;
use App\Http\Services\Searches\Filters\Employee\Name;
use App\Http\Services\Searches\Filters\Employee\Position;
use App\Http\Services\Searches\Filters\Employee\Sort;
use App\Http\Services\Searches\Filters\Employee\Status;
use App\Http\Services\Searches\HttpSearch;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class EmployeeSearch extends HttpSearch
{

    protected function passable()
    {
        return Employee::query();
    }

    protected function filters(): array
    {
        return [
            Name::class,
            Sort::class,
            Position::class,
            Active::class,
            Status::class,
        ];
    }

    protected function thenReturn($employeeSearch)
    {
        return $employeeSearch;
    }
}
