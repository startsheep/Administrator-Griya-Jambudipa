<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Employee::all();
    }

    public function map($employee): array
    {
        if ($employee->position->name == "Marketing") {
            $total = 0;
            foreach ($employee->payment as $salary) {
                $total += $salary->commission;
            }
        } else {
            $total = $employee->position->salary;
        }

        return [
            $employee->name,
            $employee->position->name,
            'Rp. ' . number_format($total, 0, ',', '.'),
            $employee->is_active == 1 ? "Aktif" : "Non-Aktif",
            $employee->status == 1 ? "Pegawai Tetap" : "Pegawai Tidak Tetap",
            url('storage/' . $employee->image)
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Pegawai',
            'Divisi',
            'Gaji',
            'Status Keaktifan',
            'Status Kepegawaian',
            'Foto',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}
