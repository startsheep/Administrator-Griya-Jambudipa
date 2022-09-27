<?php

namespace App\Exports;

use App\Models\Contractor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContractorExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Contractor::all();
    }

    public function map($contractor): array
    {
        return [
            $contractor->pic_name,
            $contractor->company_name,
            $contractor->email,
            $contractor->phone,
            $contractor->address,
            $contractor->status == 1 ? 'Aktif' : 'Non-Aktif',
            url('storage/' . $contractor->image)
        ];
    }

    public function headings(): array
    {
        return [
            'Nama PIC',
            'Nama Perusahaan',
            'Email',
            'No. telepon',
            'Alamat',
            'Status',
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
