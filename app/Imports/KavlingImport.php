<?php

namespace App\Imports;

use App\Models\HouseType;
use App\Models\Kavling;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class KavlingImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $collect) {
            $type = HouseType::where('house_type', 'like', '%' . $collect['tipe_rumah'] . '%')->first();
            if (!$type) {
                $typeId = 1;
            } else {
                $typeId = $type->id;
            }

            Kavling::create([
                'house_type_id' => $typeId,
                'block' => $collect['blok'],
                'number_kavling' => $collect['nomer_kavling'],
                'width_kavling' => $collect['lebar_muka_kavling'],
                'length_kavling' => $collect['panjang_kavling'],
                'second_length_kavling' => $collect['panjang_kavling_2'],
                'area_kavling' => $collect['luas_kavling'],
                'area_building' => $collect['luas_bangunan'],
            ]);
        }
    }
}
