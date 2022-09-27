<?php

namespace App\Http\Controllers\Export;

use App\Exports\KavlingExport;
use App\Http\Controllers\Controller;
use App\Models\HouseType;
use App\Models\Kavling;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KavlingController extends Controller
{
    public function pdf($block)
    {
        return Excel::download(new KavlingExport($block), date("Y_m_d_His") . '_REKAP_DATA_KAVLING.pdf');
    }

    public function excel($block)
    {
        return Excel::download(new KavlingExport($block), date("Y_m_d_His") . '_REKAP_DATA_KAVLING.xlsx');
    }

    public function print($block)
    {
        $data = [
            'kavlings' => Kavling::where('block', 'LIKE', '%' . $block . '%')->get(),
            'houseTypes' => HouseType::all(),
            'title' => "KAVLING"
        ];

        return view('exports.kavlings.excel', $data);
    }
}
