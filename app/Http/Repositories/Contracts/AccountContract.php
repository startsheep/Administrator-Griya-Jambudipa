<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface AccountContract
{
    public function all($request);

    public function store(array $attributes): ?Model;

    public function find($id): Model;

    public function findByCriteria(array $criteria): ?Model;

    public function update(array $attributes, $result);

    public function delete($result);

    public function changePassword(array $attributes, $result);

    public function changeStatus(array $attributes, $result);
}
