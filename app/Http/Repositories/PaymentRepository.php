<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\PaymentContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\PaymentSearch;
use App\Models\Payment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements PaymentContract
{
    /** @var Payment */
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function all($request)
    {
        $factory = app()->make(PaymentSearch::class);
        $payments = $factory->apply()->paginate($request->per_page);

        return $payments;
    }

    public function store(array $attributes)
    {
        $cekData = $this->payment->where('customer_id', $attributes['customer_id'])
            ->where('house_type_id', $attributes['house_type_id'])
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->first();

        $cekTotalPrice = $this->cekTotalPrice($cekData, $attributes['price']);
        if (!$cekTotalPrice) {
            return collect([
                'message' => 'nominal biaya masuk terlalu tinggi!',
                'type' => 'error',
                'data' => [],
                'status' => 400
            ]);
        }

        if ($cekData) {
            $cekData->update($attributes);
            $result = $cekData;
            $cekData->paymentPrice()->create([
                'price' => $attributes['price'],
            ]);
        } else {
            $result = $this->payment->create($attributes);
            $result->paymentPrice()->create([
                'price' => $attributes['price'],
            ]);
        }

        return collect([
            'message' => "success",
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function find($id): Payment
    {
        return $this->payment->findOrFail($id);
    }

    protected function cekHouseType($result, $id)
    {
        if ($result == $id) {
            return true;
        }

        return false;
    }

    protected function cekTotalPrice($result, $price)
    {
        $total = 0;
        foreach ($result->paymentPrice as $item) {
            $total += $item->price;
        }

        $total += $price;

        if ((string) $total >= $result->houseType->price + 1) {
            return false;
        }

        return true;
    }
}
