<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'email' => 'admin@example.com',
            'is_active' => 1,
        ]);
        $this->call([
//             PositionSeeder::class,
//             CustomerSeeder::class,
//             EmployeeSeeder::class,
            CompanyProfileSeeder::class,
            RoleSeeder::class,
//             HouseTypeSeeder::class
        ]);
    }
}
