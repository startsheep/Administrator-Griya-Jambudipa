<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface UserContract
{
	/**
	 * @return mixed
	 */
	public function customRules();

    public function store(array $attributes): ?Model;
}
