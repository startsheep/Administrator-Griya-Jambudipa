<?php

namespace Database\Seeders;

use App\Models\HouseType;
use App\Models\Position;
use Database\Seeders\Traits\DisableForeignKey;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HouseTypeSeeder extends Seeder
{
    use DisableForeignKey, TruncateTable;

    public function run()
    {
        $houseTypes = ["36", "45", "60", "80"];

        $this->disableForeignKeys();
        $this->truncate('house_types');

        foreach ($houseTypes as $type) {
            HouseType::create([
                "house_type" => $type,
                "description" => 'lorem',
                "price" => "10000000"
            ]);
        }

        $this->enableForeignKeys();
    }
}
