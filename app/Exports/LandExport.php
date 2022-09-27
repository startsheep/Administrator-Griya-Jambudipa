<?php

namespace App\Exports;

use App\Models\BasicPriceCategory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LandExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $data = [
            'buildings' => BasicPriceCategory::where('section', 'LIKE', '%Tanah%')->get(),
            'title' => "HARGA"
        ];

        return view('exports.buildings.excel', $data);
    }
}
