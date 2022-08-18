<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\CompanyProfileContract;
use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Http\Resources\CompanyProfileDetail;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    protected $companyProfile;

    public function __construct(CompanyProfileContract $companyProfile) {
        $this->companyProfile = $companyProfile;
    }

    public function index()
    {
        $result = $this->companyProfile->all();

        return new CompanyProfileDetail($result);
    }

    public function update(UpdateCompanyProfileRequest $request, $id)
    {
        $data = $this->companyProfile->update($request->all(), $id);
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
}
