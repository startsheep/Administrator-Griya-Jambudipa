<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\PaymentContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\PaymentSearch;
use App\Models\Customer;
use App\Models\Log;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            ->where('kavling_id', $attributes['kavling_id'])
            ->first();

        if ($cekData) {
            $cekTotalPrice = $this->cekTotalPrice($cekData, $attributes['price']);
            if (!$cekTotalPrice) {
                return collect([
                    'message' => 'nominal biaya masuk terlalu tinggi!',
                    'type' => 'error',
                    'data' => [],
                    'status' => 400
                ]);
            }

            $cekData->update($attributes);
            $result = $cekData;
            $cekData->paymentPrice()->create([
                'price' => $attributes['price'],
            ]);

            if (isset($attributes['documents'])) {
                if (isset($attributes['documents']) && $attributes['documents']) {
                    $this->multipleUpload($attributes['documents'], $result);
                }
            }
        } else {
            $result = $this->payment->create($attributes);
            $result->paymentPrice()->create([
                'price' => $attributes['price'],
            ]);

            if (isset($attributes['documents'])) {
                if (isset($attributes['documents']) && $attributes['documents']) {
                    if ($result->document) {
                        foreach ($result->document as $document) {
                            Storage::delete($document->document_path);
                            $result->document()->delete();
                        }
                    }
                    $this->multipleUpload($attributes['documents'], $result);
                }
            }
        }

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan penambahan data pada pembayaran'
        ]);

        return collect([
            'message' => "success",
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function find($id): Payment
    {
        return $this->payment->with(['customer', 'kavling.houseType', 'employee', 'paymentPrice', 'document'])->findOrFail($id);
    }

    public function customer()
    {
        $data = [];
        $customers = Customer::all();

        foreach ($customers as $customer) {
            $countPayment = $this->payment->where('customer_id', $customer->id)->count();
            $countKavling = $customer->customerKavling->count();

            if ($countKavling != $countPayment) {
                $data[] = $customer;
            }
        }

        return $data;
    }

    protected function cekHouseType($payments, $customer)
    {
        $cek = false;

        foreach ($payments as $payment) {
            if ($payment->customer_id == $customer->id) {
                $cek = $this->finishingPayment($payment, $customer);
            }
        }

        return $cek;
    }

    protected function finishingPayment($payment, $customer)
    {
        $cek = false;
        $data = 0;

        foreach ($payment->paymentPrice as $price) {
            foreach ($customer->customerKavling as $kavling) {
                if ($payment->kavling->houseType->id == $kavling->kavling->houseType->id) {
                    $data = $price->price - $kavling->kavling->houseType->price;
                }
            }
        }

        if ($data == 0) {
            $cek = true;
        }

        return $cek;
    }

    protected function cekTotalPrice($result, $price)
    {
        $total = 0;
        foreach ($result->paymentPrice as $item) {
            $total += $item->price;
        }

        $total += $price;

        if ((string) $total >= $result->kavling->houseType->price + 1) {
            return false;
        }

        return true;
    }

    protected function storageFile($file, $folder)
    {
        $path = $file->store($folder);
        return $path;
    }

    protected function multipleUpload($files, $model)
    {
        foreach ($files as $file) {
            $document = $this->storageFile($file, 'payment');
            $request['document_path'] = $document;
            $request['document_name'] = $file->getClientOriginalName();
            $model->document()->create($request);
        }
    }
}
