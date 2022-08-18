<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\EmployeeContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\EmployeeSearch;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class EmployeeRepository implements EmployeeContract
{
    /** @var Employee */
    protected $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function all($request)
    {
        $factory = app()->make(EmployeeSearch::class);
        $employees = $factory->apply()->with('position')->paginate($request->per_page);

        return $employees;
    }

    public function store(array $attributes): Employee
    {
        if (isset($attributes['image'])) {
            if (isset($attributes['image']) && $attributes['image']) {
                $attributes['image'] = $attributes['image']->store('employee');
            }
        }
        $attributes['is_active'] = 1;
        return $this->employee->create($attributes);
    }

    public function find($id): Employee
    {
        return $this->employee->with('position')->find($id);
    }

    public function update(array $attributes, $result)
    {
        if (isset($attributes['image'])) {
            if (isset($attributes['image']) && $attributes['image']) {
                Storage::delete($result->image);
                $attributes['image'] = $attributes['image']->store('employee');
            }
        }

        $result->update($attributes);

        return collect([
            'message' => "success",
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function updateActive(array $attributes, $result)
    {
        $result->is_active = $attributes['active'] ? 1 : 2;
        $result->save();

        return collect([
            'message' => "success",
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function delete($result)
    {
        Storage::delete($result->image);

        return $result->delete();
    }
}
