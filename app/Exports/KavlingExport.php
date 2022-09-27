<?php

namespace App\Exports;

use App\Models\HouseType;
use App\Models\Kavling;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KavlingExport implements FromView, ShouldAutoSize
{
    protected $block;

    public function __construct($block)
    {
        $this->block = $block;
    }

    public function view(): View
    {
        $data = [
            'kavlings' => Kavling::where('block', 'LIKE', '%' . $this->block . '%')->get(),
            'houseTypes' => HouseType::all(),
            'title' => "KAVLING"
        ];

        return view('exports.kavlings.excel', $data);
    }
}
