<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'name' => "Marketing",
            'salary' => "0"
        ]);

        Position::create([
            'name' => "Manager",
            'salary' => "2000000"
        ]);
    }
}
