<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\PaymentContract;
use App\Http\Requests\Payment\CreatePaymentRequest;
use App\Http\Resources\Payment\PaymentCollection;
use App\Http\Resources\Payment\PaymentDetail;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentRepository;

    public function __construct(PaymentContract $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function index(Request $request)
    {
        $result = $this->paymentRepository->all($request);

        return new PaymentCollection($result);
    }

    public function store(CreatePaymentRequest $request)
    {
        $result = $this->paymentRepository->store($request->all());

        $output = $result;
        return response()->json(
            [
                'message' => $output['message'],
                'type' => $output['type'],
                'result' => $output['data']
            ],
            $output['status']
        );
    }

    public function show($id)
    {
        $result = $this->paymentRepository->find($id);

        return new PaymentDetail($result);
    }
}
