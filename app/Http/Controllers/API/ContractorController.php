<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\ContractorContract;
use App\Http\Requests\Contractor\CreateContractorRequest;
use App\Http\Requests\Contractor\UpdateContractorRequest;
use App\Http\Resources\Contractor\ContractorCollection;
use App\Http\Resources\Contractor\ContractorDetail;
use Illuminate\Http\Request;

class ContractorController extends Controller
{
    protected $contractorRepository;

    public function __construct(ContractorContract $contractorRepository)
    {
        $this->contractorRepository = $contractorRepository;
    }

    public function index(Request $request)
    {
        $result = $this->contractorRepository->all($request);

        return new ContractorCollection($result);
    }

    public function store(CreateContractorRequest $request)
    {
        $result = $this->contractorRepository->store($request->all());
        $output = $result;
        return response()->json(
            [
                'message' => $output['message'],
                'result' => $output['data'],
                'type' => $output['type'],
            ],
            $output['status']
        );
    }

    public function show($id)
    {
        $result = $this->contractorRepository->find($id);

        return new ContractorDetail($result);
    }

    public function update(UpdateContractorRequest $request, $id)
    {
        $result = $this->contractorRepository->find($id);

        $data = $this->contractorRepository->update($request->all(), $result);
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
        $result = $this->contractorRepository->find($id);
        $this->contractorRepository->delete($result);

        return new ContractorDetail($result);
    }
}
