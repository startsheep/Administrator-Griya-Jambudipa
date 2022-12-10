<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CompanyProfile\CompanyProfileRepository;
use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Http\Resources\CompanyProfileDetail;
use App\Http\Services\Traits\Log;
use App\Http\Services\Traits\MessageFixer;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    use Log, MessageFixer;

    protected $companyProfile;

    public function __construct(CompanyProfileRepository $companyProfile)
    {
        $this->companyProfile = $companyProfile;
    }

    public function index()
    {
        $result = $this->companyProfile->find(CompanyProfile::STATIC_ID);

        return new CompanyProfileDetail($result);
    }

    public function update(UpdateCompanyProfileRequest $request, $id)
    {
        $attributes = $request->all();

        $companyProfile = $this->companyProfile->find($id);

        if (isset($attributes['logo']) && $attributes['logo']) {
            if ($companyProfile->logo) {
                Storage::delete($companyProfile->logo);
            }

            $attributes['logo'] = $attributes['logo']->store('company_profile');
        }

        return DB::transaction(function () use ($companyProfile, $attributes) {
            $this->createLog('melakukan perubahan pada profil perusahaan');

            return $this->companyProfile->update($companyProfile->id, $attributes);
        });
    }
}
