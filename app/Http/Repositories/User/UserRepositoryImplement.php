<?php

namespace App\Http\Repositories\User;

use App\Http\Services\Traits\QueryWhere;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;

class UserRepositoryImplement extends Eloquent implements UserRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findByCriteria(array $criteria): ?User
    {
        return $this->model->where($criteria)->first();
    }
}
