<?php

namespace App\Imports;

use App\Models\BasicPrice;
use App\Models\BasicPriceCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BasicCategoryPriceImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // foreach ($collection as $collect) {
        //     if ($collect['uraian'] != null) {
        //         $category = null;
        //         if ($collect['induk'] == null && empty($collect)) {
        //             $category = BasicPriceCategory::create([
        //                 'category' => $collect['uraian'],
        //                 'section' => strtolower(request('section'))
        //             ]);
        //         } else {
        //             BasicPrice::create([
        //                 'basic_price_category_id' => $category->id,
        //             ]);
        //         }
        //     }
        // }
    }
}
