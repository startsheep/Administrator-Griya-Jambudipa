<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\DashboardContract;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardRepository;

    public function __construct(DashboardContract $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function countCustomer()
    {
        $result = $this->dashboardRepository->countCustomer();

        return $result;
    }

    public function countTransaction()
    {
        $result = $this->dashboardRepository->countTransaction();

        return $result;
    }

    public function countProfit()
    {
        $result = $this->dashboardRepository->countProfit();

        return $result;
    }

    public function countWholeJob()
    {
        $result = $this->dashboardRepository->countWholeJob();

        return $result;
    }

    public function countEmployee()
    {
        $result = $this->dashboardRepository->countEmployee();

        return $result;
    }

    public function countContractor()
    {
        $result = $this->dashboardRepository->countContractor();

        return $result;
    }

    public function countKavling()
    {
        $result = $this->dashboardRepository->countKavling();

        return $result;
    }

    public function countHouseType()
    {
        $result = $this->dashboardRepository->countHouseType();

        return $result;
    }

    public function kavling()
    {
        $result = $this->dashboardRepository->kavling();

        return $result;
    }

    public function graph()
    {
        $result = $this->dashboardRepository->graph();

        return $result;
    }
}
