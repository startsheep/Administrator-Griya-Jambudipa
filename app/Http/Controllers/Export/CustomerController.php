<?php

namespace App\Http\Controllers\Export;

use App\Exports\CustomerExport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function pdf()
    {
        return Excel::download(new CustomerExport, date("Y_m_d_His") . '_REKAP_DATA_CUSTOMER.pdf');
    }

    public function excel()
    {
        return Excel::download(new CustomerExport, date("Y_m_d_His") . '_REKAP_DATA_CUSTOMER.xlsx');
    }

    public function print()
    {
        $data = [
            'customers' => Customer::all(),
            'title' => "CUSTOMER"
        ];

        return view('exports.customers.excel', $data);
    }
}
