<?php

namespace App\Http\Controllers\Export;

use App\Exports\JobOtherExport;
use App\Http\Controllers\Controller;
use App\Models\WholeJob;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JobOtherController extends Controller
{
    public function pdf()
    {
        return Excel::download(new JobOtherExport, date("Y_m_d_His") . '_REKAP_DATA_BORONGAN_LAINNYA.pdf');
    }

    public function excel()
    {
        return Excel::download(new JobOtherExport, date("Y_m_d_His") . '_REKAP_DATA_BORONGAN_LAINNYA.xlsx');
    }

    public function print()
    {
        $data = [
            'wholeJobs' => WholeJob::where('type', 'Umum')->get(),
            'title' => "BORONGAN PEKERJAAN LAINNYA"
        ];

        return view('exports.job-houses.excel', $data);
    }
}
