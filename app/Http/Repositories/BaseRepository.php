<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\BaseContract;
use App\Http\Repositories\Contracts\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryContract
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find($id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function findByCriteria(array $criteria): ?Model
    {
        return $this->model
            ->where($criteria)
            ->first();
    }

    public function getByCriteria(array $criteria): Collection
    {
        return $this->model
            ->where($criteria)
            ->get();
    }

    public function store(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(array $attributes, $id)
    {
        return $this->model
            ->where('id', $id)
            ->update($attributes);
    }

    public function delete($id)
    {
        return $this->model
            ->where('id', $id)
            ->delete();
    }
}
