<?php

namespace App\Http\Repositories\Position;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Position;

class PositionRepositoryImplement extends Eloquent implements PositionRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Position $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
