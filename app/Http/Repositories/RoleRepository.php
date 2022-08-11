<?php

namespace App\Http\Repositories;

use App\Models\Role;
use Illuminate\Support\Collection;
use App\Http\Repositories\Contracts\RoleContract;

class RoleRepository implements RoleContract
{
	/** @var Role */
	protected $role;

	public function __construct(Role $role)
	{
		$this->role = $role;
	}

	public function all(): Collection
	{
		return $this->role->all();
	}

    public function store(array $attributes): Role
    {
        return $this->role->create($attributes);
    }

    public function find($id): Role
    {
        return $this->role->findOrFail($id);
    }

    public function update(array $attributes, $result)
    {
        return $result->update($attributes);
    }

    public function delete($result)
    {
        return $result->delete();
    }
}
