<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BasicPriceCategoryContract
{
    public function all($request);

    public function store(array $attributes);

    public function import(array $attributes);

    public function find($id): Model;

    public function update(array $attributes, $result);

    public function delete($result);
}
