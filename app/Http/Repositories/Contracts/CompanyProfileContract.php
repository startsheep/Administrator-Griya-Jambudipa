<?php

namespace App\Http\Repositories\Contracts;

interface CompanyProfileContract
{
	public function all();

	public function update(array $attributes, $id);
}
