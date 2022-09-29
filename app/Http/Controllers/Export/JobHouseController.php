<?php

namespace App\Http\Controllers\Export;

use App\Exports\JobHouseExport;
use App\Http\Controllers\Controller;
use App\Models\WholeJob;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JobHouseController extends Controller
{
    public function pdf()
    {
        return Excel::download(new JobHouseExport, date("Y_m_d_His") . '_REKAP_DATA_BORONGAN_RUMAH.pdf');
    }

    public function excel()
    {
        return Excel::download(new JobHouseExport, date("Y_m_d_His") . '_REKAP_DATA_BORONGAN_RUMAH.xlsx');
    }

    public function print()
    {
        $data = [
            'wholeJobs' => WholeJob::where('type', 'rumah')->get(),
            'title' => "BORONGAN PEKERJAAN RUMAH"
        ];

        return view('exports.job-houses.excel', $data);
    }
}
