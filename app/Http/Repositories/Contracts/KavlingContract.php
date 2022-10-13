<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface KavlingContract
{
    public function all($request);

    public function store(array $attributes): ?Model;

    public function import(array $attributes);

    public function find($id): Model;

    public function paymentCheck($customer_id);

    public function update(array $attributes, $result);

    public function delete($result);
}
