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
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->first();

        if ($cekData) {
            $cekData->update($attributes);
            $result = $cekData;
            $cekData->paymentPrice()->create([
                'price' => $attributes['price']
            ]);
        } else {
            $result = $this->payment->create($attributes);
            $result->paymentPrice()->create([
                'price' => $attributes['price']
            ]);
        }

        return $result;
    }

    public function find($id): Payment
    {
        return $this->payment->find($id);
    }
}
