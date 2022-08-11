<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RoleContract
{
	public function all(): Collection;

    public function store(array $attributes): ?Model;

    public function find($id): Model;

    public function update(array $attributes, Model $result);

    public function delete(Model $result);
}
