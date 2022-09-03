<?php

namespace Database\Seeders;

use App\Models\BuildingPriceCategory;
use Database\Seeders\Traits\DisableForeignKey;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class buildingPriceCategorySeeder extends Seeder
{
    use DisableForeignKey;
    use TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate('building_price_categories');

        BuildingPriceCategory::create([
            'category' => "Tidak diketahui!"
        ]);
        $this->enableForeignKeys();
    }
}
