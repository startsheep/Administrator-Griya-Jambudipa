<?php

namespace App\Exports;

use App\Models\WholeJob;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JobHouseExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $data = [
            'wholeJobs' => WholeJob::where('type', 'Rumah')->get(),
            'title' => "BORONGAN RUMAH"
        ];

        return view('exports.job-houses.excel', $data);
    }
}
