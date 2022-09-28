<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $payments = Payment::get();
        $data = [
            'payments' => $this->checkPayment($payments),
            'title' => "TRANSAKSI"
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
                if ($reminderPrice == 0) {
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
