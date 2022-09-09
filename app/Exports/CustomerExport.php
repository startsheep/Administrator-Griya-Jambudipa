<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Customer::all();
    }

    public function map($customer): array
    {
        foreach ($customer->customerKavling as $kavling) {
            $kavling = $kavling->kavling->block . '-' . $kavling->kavling->number_kavling . '/' . $kavling->kavling->houseType->house_type;
        }

        return [
            $customer->name,
            $customer->email,
            $customer->phone,
            $customer->profession,
            $customer->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            $customer->address,
            $customer->is_active == 1 ? 'Aktif' : 'Non-Aktif',
            $kavling,
            url('storage/' . $customer->image)
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'No. telepon',
            'Profesi',
            'Jenis Kelamin',
            'Alamat',
            'Status',
            'Blok Kavling',
            'Foto',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A3);
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}
