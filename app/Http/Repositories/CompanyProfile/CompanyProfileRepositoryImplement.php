<?php

namespace App\Http\Repositories\CompanyProfile;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\CompanyProfile;

class CompanyProfileRepositoryImplement extends Eloquent implements CompanyProfileRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(CompanyProfile $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
