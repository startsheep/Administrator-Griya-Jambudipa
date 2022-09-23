<?php

namespace App\Http\Repositories\Contracts;

interface LogContract
{
    public function all($request);

    public function find($id);
}
