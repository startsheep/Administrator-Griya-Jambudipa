<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'is_active' => 1,
        ]);

        $this->call([
            PositionSeeder::class,
            CustomerSeeder::class,
            EmployeeSeeder::class,
            CompanyProfileSeeder::class,
            RoleSeeder::class,
            HouseTypeSeeder::class
        ]);
    }
}
