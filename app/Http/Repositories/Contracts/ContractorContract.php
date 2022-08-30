<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ContractorContract
{
    public function all($request);

    public function store(array $attributes): ?Collection;

    public function find($id): Model;

    public function update(array $attributes, $result);

    public function delete($result);
}
