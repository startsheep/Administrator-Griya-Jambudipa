<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\CustomerContract;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\Customer\CustomerCollection;
use App\Http\Resources\Customer\CustomerDetail;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerRepository;

    public function __construct(CustomerContract $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index(Request $request)
    {
        $result = $this->customerRepository->all($request);

        return new CustomerCollection($result);
    }

    public function store(CreateCustomerRequest $request)
    {
        $result = $this->customerRepository->store($request->all());
        $output = $result;
        return response()->json(
            [
                'message' => $output['message'],
                'type' => $output['type'],
            ],
            $output['status']
        );
    }

    public function show($id)
    {
        $result = $this->customerRepository->find($id);

        return new CustomerDetail($result);
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        $result = $this->customerRepository->find($id);

        $data = $this->customerRepository->update($request->all(), $result);
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
        $result = $this->customerRepository->find($id);
        $this->customerRepository->delete($result);

        return new CustomerDetail($result);
    }
}
