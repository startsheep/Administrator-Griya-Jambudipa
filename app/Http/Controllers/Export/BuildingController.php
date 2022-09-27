<?php

namespace App\Http\Controllers\Export;

use App\Exports\BuildingExport;
use App\Http\Controllers\Controller;
use App\Models\BasicPriceCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BuildingController extends Controller
{
    public function pdf()
    {
        return Excel::download(new BuildingExport, date("Y_m_d_His") . '_REKAP_DATA_HARGA_DASAR_BANGUNAN.pdf');
    }

    public function excel()
    {
        return Excel::download(new BuildingExport, date("Y_m_d_His") . '_REKAP_DATA_HARGA_DASAR_BANGUNAN.xlsx');
    }

    public function print()
    {
        $data = [
            'buildings' => BasicPriceCategory::where('section', 'LIKE', '%Bangunan%')->get(),
            'title' => "HARGA DASAR BANGUNAN"
        ];

        return view('exports.buildings.excel', $data);
    }
}
