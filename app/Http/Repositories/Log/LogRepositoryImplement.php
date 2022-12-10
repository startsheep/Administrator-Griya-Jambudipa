<?php

namespace App\Http\Repositories\Log;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Log;

class LogRepositoryImplement extends Eloquent implements LogRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Log $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
