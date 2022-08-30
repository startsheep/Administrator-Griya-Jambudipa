<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\Filters\Payment\PriceHouse;
use App\Http\Services\Searches\HttpSearch;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class PaymentSearch extends HttpSearch
{

    protected function passable()
    {
        return Payment::query();
    }

    protected function filters(): array
    {
        return [
            PriceHouse::class
        ];
    }

    protected function thenReturn($paymentSearch)
    {
        return $paymentSearch;
    }
}
