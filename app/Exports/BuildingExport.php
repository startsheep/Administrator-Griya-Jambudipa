<?php

namespace App\Exports;

use App\Models\BasicPriceCategory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BuildingExport implements FromView, ShouldAutoSize, WithStyles
{
    public function view(): View
    {
        $data = [
            'buildings' => BasicPriceCategory::where('section', 'LIKE', '%Bangunan%')->get(),
            'title' => "HARG"
        ];

        return view('exports.buildings.excel', $data);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => Color::COLOR_BLUE],
                ]
            ]
        ];
    }
}
