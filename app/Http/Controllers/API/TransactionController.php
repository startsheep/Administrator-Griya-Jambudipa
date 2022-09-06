<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction\TransactionCollection;
use App\Http\Resources\Transaction\TransactionDetail;
use App\Http\Services\Searches\PaymentSearch;
use App\Models\Payment;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $paymentRepository;

    public function __construct(Payment $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function index(Request $request)
    {
        $factory = app()->make(PaymentSearch::class);
        $payments = $factory->apply()->paginate($request->per_page);

        return new TransactionCollection($payments);
    }

    public function show($id)
    {
        $result = $this->paymentRepository->with(['customer', 'houseType', 'employee', 'paymentPrice'])->find($id);

        return new TransactionDetail($result);
    }
}
