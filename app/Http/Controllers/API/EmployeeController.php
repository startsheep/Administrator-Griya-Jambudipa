<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\EmployeeContract;
use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\Employee\EmployeeCollection;
use App\Http\Resources\Employee\EmployeeDetail;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeContract $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index(Request $request)
    {
        $result = $this->employeeRepository->all($request);

        return new EmployeeCollection($result);
    }

    public function store(CreateEmployeeRequest $request)
    {
        $result = $this->employeeRepository->store($request->all());

        return response()->json([
            'message' => 'success',
            'data' => $result
        ]);
    }

    public function show($id)
    {
        $result = $this->employeeRepository->find($id);

        return new EmployeeDetail($result);
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        $result = $this->employeeRepository->find($id);

        $data = $this->employeeRepository->update($request->all(), $result);
        $output = $data;
        return response()->json(
            [
                'message' => $output['message'],
                'type' => $output['type'],
                'result' => $output['data']
            ],
            $output['status']
        );
    }

    public function updateActive(Request $request, $id)
    {
        $result = $this->employeeRepository->find($id);

        $data = $this->employeeRepository->updateActive($request->all(), $result);
        $output = $data;
        return response()->json(
            [
                'message' => $output['message'],
                'type' => $output['type'],
                'result' => $output['data']
            ],
            $output['status']
        );
    }

    public function delete($id)
    {
        $result = $this->employeeRepository->find($id);
        $this->employeeRepository->delete($result);

        return new EmployeeDetail($result);
    }
}
