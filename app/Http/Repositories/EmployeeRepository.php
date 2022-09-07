<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\EmployeeContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\EmployeeSearch;
use App\Models\Employee;
use Illuminate\Support\Str;
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
        $employees = $factory->apply()->with(['position', 'document'])->paginate($request->per_page);

        return $employees;
    }

    public function store(array $attributes): Employee
    {
        if (isset($attributes['image'])) {
            if (isset($attributes['image']) && $attributes['image']) {
                $attributes['image'] = $attributes['image']->store('employee');
            }
        }

        $attributes['referal_code'] = Str::random(6);
        $attributes['is_active'] = 1;
        $result = $this->employee->create($attributes);

        if (isset($attributes['documents'])) {
            if (isset($attributes['documents']) && $attributes['documents']) {
                $this->multipleUpload($attributes['documents'], $result);
            }
        }

        return $result;
    }

    public function find($id): Employee
    {
        return $this->employee->with(['position', 'document'])->findOrFail($id);
    }

    public function update(array $attributes, $result)
    {
        if (isset($attributes['image'])  && $attributes['image']) {
            if (isset($attributes['image']) && $attributes['image']) {
                if ($result->image != null) {

                    Storage::delete($result->image);
                }
                $attributes['image'] = $attributes['image']->store('employee');
            }
        }

        $result->update($attributes);

        if (isset($attributes['documents'])) {
            if (isset($attributes['documents']) && $attributes['documents']) {
                if ($result->document) {
                    foreach ($result->document as $document) {
                        Storage::delete($document->document_path);
                        $result->document()->delete();
                    }
                }
                $this->multipleUpload($attributes['documents'], $result);
            }
        }

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
        if (count($result->document) > 0) {
            foreach ($result->document as $document) {
                Storage::delete($document->document_path);
            }

            $result->document()->delete();
        }

        if ($result->image != null) {
            Storage::delete($result->image);
        }

        return $result->delete();
    }

    protected function storageFile($file, $folder)
    {
        $path = $file->store($folder);
        return $path;
    }

    protected function multipleUpload($files, $model)
    {
        foreach ($files as $file) {
            $document = $this->storageFile($file, 'document_employee');
            $request['document_path'] = $document;
            $request['document_name'] = $file->getClientOriginalName();
            $model->document()->create($request);
        }
    }
}
