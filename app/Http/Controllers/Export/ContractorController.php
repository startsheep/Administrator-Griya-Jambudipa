<?php

namespace App\Http\Controllers\Export;

use App\Exports\ContractorExport;
use App\Http\Controllers\Controller;
use App\Models\Contractor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ContractorController extends Controller
{
    public function pdf()
    {
        return Excel::download(new ContractorExport, date("Y_m_d_His") . '_REKAP_DATA_PEMBORONG.pdf');
    }

    public function excel()
    {
        return Excel::download(new ContractorExport, date("Y_m_d_His") . '_REKAP_DATA_PEMBORONG.xlsx');
    }

    public function print()
    {
        $data = [
            'contractors' => Contractor::all(),
            'title' => "PEMBORONG"
        ];

        return view('exports.contractor.excel', $data);
    }
}
