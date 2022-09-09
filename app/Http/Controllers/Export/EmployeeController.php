<?php

namespace App\Http\Controllers\Export;

use App\Exports\EmployeeExport;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function pdf()
    {
        return Excel::download(new EmployeeExport, date("Y_m_d_His") . '_REKAP_DATA_PEGAWAI.pdf');
    }

    public function excel()
    {
        return Excel::download(new EmployeeExport, date("Y_m_d_His") . '_REKAP_DATA_PEGAWAI.xlsx');
    }

    public function print()
    {
        $data = [
            'employees' => Employee::all()
        ];

        return view('exports.employees.excel', $data);
    }
}
