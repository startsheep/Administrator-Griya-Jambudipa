<?php

namespace App\Http\Services\Searches;

use App\Http\Services\Searches\Filters\Payment\PriceHouse;
use App\Http\Services\Searches\Filters\Transaction\Recapitulation;
use App\Http\Services\Searches\Filters\Transaction\Search;
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
            Recapitulation::class,
            Search::class
        ];
    }

    protected function thenReturn($paymentSearch)
    {
        return $paymentSearch;
    }
}
