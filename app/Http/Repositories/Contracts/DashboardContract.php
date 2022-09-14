<?php

namespace App\Http\Repositories\Contracts;

interface DashboardContract
{
    public function countCustomer();

    public function countTransaction();

    public function kavling();

    public function graph();
}
