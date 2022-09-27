<?php

namespace App\Http\Controllers\Export;

use App\Exports\BuildingExport;
use App\Exports\LandExport;
use App\Http\Controllers\Controller;
use App\Models\BasicPriceCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LandController extends Controller
{
    public function pdf()
    {
        return Excel::download(new LandExport, date("Y_m_d_His") . '_REKAP_DATA_HARGA_DASAR_TANAH.pdf');
    }

    public function excel()
    {
        return Excel::download(new LandExport, date("Y_m_d_His") . '_REKAP_DATA_HARGA_DASAR_TANAH.xlsx');
    }

    public function print()
    {
        $data = [
            'buildings' => BasicPriceCategory::where('section', 'LIKE', '%Tanah%')->get(),
            'title' => "HARGA DASAR TANAH"
        ];

        return view('exports.buildings.excel', $data);
    }
}
