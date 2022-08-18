<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\CompanyProfileContract;
use App\Http\Repositories\BaseRepository;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Storage;

class CompanyProfileRepository implements CompanyProfileContract
{
	/** @var CompanyProfile */
	protected $companyProfile;

	public function __construct(CompanyProfile $companyProfile)
	{
		$this->companyProfile = $companyProfile;
	}

	public function all() {
        $result = $this->companyProfile->first();

        return $result;
    }

	public function update(array $attributes, $id) {
        $result = $this->companyProfile->find($id);

        if (isset($attributes['logo'])) {
            if (isset($attributes['logo']) && $attributes['logo']) {
                if ($result->logo != null) {
                    Storage::delete($result->logo);
                }

                $attributes['logo'] = $attributes['logo']->store('company_profile');
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
}
