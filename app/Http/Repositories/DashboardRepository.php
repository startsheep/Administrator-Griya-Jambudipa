<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\DashboardContract;
use App\Http\Repositories\BaseRepository;
use App\Models\Customer;
use App\Models\Kavling;
use App\Models\Payment;

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
}
