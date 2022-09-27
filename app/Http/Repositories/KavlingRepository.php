<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\KavlingContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\KavlingSearch;
use App\Models\CustomerKavling;
use App\Models\Kavling;
use App\Models\Log;
use App\Models\Payment;
use Illuminate\Support\Str;

class KavlingRepository implements KavlingContract
{
    /** @var Kavling */
    protected $kavling;

    public function __construct(Kavling $kavling)
    {
        $this->kavling = $kavling;
    }

    public function all($request)
    {
        $factory = app()->make(KavlingSearch::class);
        $kavlings = $factory->apply()->with('houseType')->paginate($request->per_page);

        return $kavlings;
    }

    public function store(array $attributes): Kavling
    {
        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan penambahan data pada kavling'
        ]);

        return $this->kavling->create($attributes);
    }

    public function find($id): Kavling
    {
        return $this->kavling->with('houseType')->findOrFail($id);
    }

    public function update(array $attributes, $result)
    {
        $result->update($attributes);

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan perubahan data pada kavling'
        ]);

        return collect([
            'message' => "success",
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function delete($result)
    {
        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan penghapusan data pada kavling'
        ]);

        return $result->delete();
    }

    public function paymentCheck($customer_id)
    {
        $customerKavlings = CustomerKavling::where('customer_id', $customer_id)->get();
        $data = [];

        foreach ($customerKavlings as $customerKavling) {
            $payment = Payment::where('customer_id', $customer_id)->where('kavling_id', $customerKavling->kavling_id)->first();

            if (!$payment) {
                $customerKavling->kavling->houseType;
                $data[] = $customerKavling;
            }
        }

        return $data;
    }

    protected function checkPrice($resultPayment, $resultHouseType)
    {
        $price = 0;

        foreach ($resultPayment as $item) {
            $price += $item->price;
        }

        $result = $price - $resultHouseType->price;

        $response = false;

        if ($result == 0) {
            $response = true;
        }

        return $response;
    }
}
