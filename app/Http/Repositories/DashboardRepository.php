<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\DashboardContract;
use App\Http\Repositories\BaseRepository;
use App\Models\Contractor;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\HouseType;
use App\Models\Kavling;
use App\Models\Payment;
use App\Models\WholeJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardContract
{
    public function countCustomer()
    {
        $customerActive = Customer::where('is_active', 1)->get()->count();
        $customerNoActive = Customer::where('is_active', '!=', 1)->get()->count();

        return response()->json([
            'message' => 'success',
            'data' => [
                'customer_active' => $customerActive,
                'customer_no_active' => $customerNoActive,
            ]
        ], 200);
    }

    public function countTransaction()
    {
        $transaction = Payment::all()->count();

        return response()->json([
            'message' => 'success',
            'data' => [
                'transaction' => $transaction,
            ]
        ], 200);
    }

    public function countProfit()
    {
        $customers = Customer::all();
        $payments = Payment::all();
        $wholeJobs = WholeJob::all();

        $housePrice = $this->housePrice($customers);
        $paymentPrice = $this->paymentPrice($payments);
        $wholeJobPrice = $this->wholeJobPrice($wholeJobs);

        $price = $housePrice - ($paymentPrice + $wholeJobPrice);

        return response()->json([
            'message' => 'success',
            'data' => [
                'price' => $price,
            ]
        ], 200);
    }

    public function countWholeJob()
    {
        $wholeJobs = WholeJob::where('end_date', '<=', Carbon::today()->toDateTimeString())->get()->count();

        return response()->json([
            'message' => 'success',
            'data' => [
                'whole_job' => $wholeJobs,
            ]
        ], 200);
    }

    public function countEmployee()
    {
        $employeeActive = Employee::where('is_active', 1)->get()->count();
        $employeeNoActive = Employee::where('is_active', '!=', 1)->get()->count();

        return response()->json([
            'message' => 'success',
            'data' => [
                'employee_active' => $employeeActive,
                'employee_no_active' => $employeeNoActive,
            ]
        ], 200);
    }

    public function countContractor()
    {
        $contractorActive = Contractor::where('status', 1)->get()->count();
        $contractorNoActive = Contractor::where('status', '!=', 1)->get()->count();

        return response()->json([
            'message' => 'success',
            'data' => [
                'contractor_active' => $contractorActive,
                'contractor_no_active' => $contractorNoActive,
            ]
        ], 200);
    }

    public function countKavling()
    {
        $kavling = Kavling::all()->count();

        return response()->json([
            'message' => 'success',
            'data' => [
                'kavling' => $kavling,
            ]
        ], 200);
    }

    public function countHouseType()
    {
        $houseType = HouseType::all()->count();

        return response()->json([
            'message' => 'success',
            'data' => [
                'house_type' => $houseType,
            ]
        ], 200);
    }

    public function kavling()
    {
        $kavlings = Kavling::all();

        $data = array();
        $status = 0;

        foreach ($kavlings as $kavling) {
            if ($kavling->customerKavling) {
                $status = 1;
            }

            $data[] = [
                "id" => $kavling->id,
                "house_type_id" => $kavling->house_type_id,
                "block" => $kavling->block,
                "number_kavling" => $kavling->number_kavling,
                "width_kavling" => $kavling->width_kavling,
                "length_kavling" => $kavling->length_kavling,
                "area_kavling" => $kavling->area_kavling,
                "area_building" => $kavling->area_building,
                "created_at" => $kavling->created_at,
                "updated_at" => $kavling->updated_at,
                "status" => $status
            ];
        }

        return response()->json([
            'message' => 'success',
            'data' => [
                'kavlings' => $data,
            ]
        ], 200);
    }

    public function graph()
    {
        $year = date("Y");

        if (request()->year) {
            $year = request()->year;
        }

        $counters = [];
        $month = $this->cekMonth();

        for ($i = 1; $i <= $month; $i++) {
            $counters[Carbon::now()->isoFormat('') . sprintf("%02d", $i)] = [
                "pemasukan" => 0,
                "pengeluaran" => 0
            ];
        }

        $payments = Payment::select(
            DB::raw("count(*) as value, DATE_FORMAT(created_at, '%m') AS date"),
        )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw("date"))->get();

        $payments2 = Payment::all();

        foreach ($payments as $key => $item) {
            $counters[$item->date] = [
                "pemasukan" => $this->income($payments2[$key]),
                "pengeluaran" => 0
            ];
        }

        return response()->json([
            'message' => 'success',
            'data' => $counters
        ], 200);
    }

    protected function cekMonth()
    {
        $carbon = Carbon::now();
        $month = $carbon->endOfYear()->format('m');
        return $month;
    }

    protected function income($result)
    {
        $price = 0;

        foreach ($result->paymentPrice as $payment) {
            $price += $payment->price;
        }

        return $price;
    }

    protected function housePrice($result)
    {
        $price = 0;

        foreach ($result as $item) {
            foreach ($item->customerKavling as $kavling) {
                $price += $kavling->kavling->houseType->price;
            }
        }

        return $price;
    }

    protected function paymentPrice($result)
    {
        $price = 0;

        foreach ($result as $item) {
            if ($item->commission == null) {
                $item->commission = 0;
            }

            $price += $item->commission;
        }

        return $price;
    }

    protected function wholeJobPrice($result)
    {
        $price = 0;

        foreach ($result as $item) {
            $price += $item->total_cost;
        }

        return $price;
    }
}
