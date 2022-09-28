<?php

namespace App\Http\Controllers\Export;

use App\Exports\PaymentExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Payment\PaymentCollection;
use App\Models\Payment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    public function pdf()
    {
        return Excel::download(new PaymentExport, date("Y_m_d_His") . '_REKAP_DATA_PEMBAYARAN.pdf');
    }

    public function excel()
    {
        return Excel::download(new PaymentExport, date("Y_m_d_His") . '_REKAP_DATA_PEMBAYARAN.xlsx');
    }

    public function print()
    {
        $payments = Payment::get();
        $data = [
            'payments' => $this->checkPayment($payments),
            'title' => "PEMBAYARAN"
        ];

        return view('exports.payments.excel', $data);
    }

    protected function checkPayment($result)
    {
        $data = [];

        foreach ($result as $item) {
            $reminderPrice = (string) $this->reminderPrice($item->kavling->houseType->price, $item->paymentPrice);
            $cekData = $item->customer()->first();

            if ($cekData) {
                if ($reminderPrice != 0) {
                    $data[] = [
                        "id" => $item->id,
                        "reminder_payment" => $reminderPrice,
                        "type" => $item->type,
                        "block" => $item->kavling,
                        "customer" => $item->customer,
                        "documents" => $item->document,
                        "created_at" => $item->created_at,
                        "updated_at" => $item->updated_at,
                    ];
                }
            }
        }

        return $data;
    }

    protected function reminderPrice($price, $result)
    {
        $total = 0;
        foreach ($result as $item) {
            $total += $item->price;
        }

        $price -= $total;

        return $price;
    }
}
