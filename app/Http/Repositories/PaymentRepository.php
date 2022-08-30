<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\PaymentContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\PaymentSearch;
use App\Models\Payment;
use Illuminate\Support\Collection;

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
        return $this->payment->create($attributes);
    }

    public function find($id): Payment
    {
        return $this->payment->find($id);
    }
}
