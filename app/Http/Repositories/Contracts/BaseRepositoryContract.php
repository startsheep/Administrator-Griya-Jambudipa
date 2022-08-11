<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryContract
{
    public function all(): Collection;

    public function find($id): Model;

    public function findByCriteria(array $criteria): ?Model;

    public function getByCriteria(array $criteria): ?Collection;

    public function store(array $attributes): ?Model;

    public function update(array $attributes, $id);

    public function delete($id);
}
