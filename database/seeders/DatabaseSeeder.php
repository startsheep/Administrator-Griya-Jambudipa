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
        $this->call([
            PositionSeeder::class,
            CompanyProfileSeeder::class,
            buildingPriceCategorySeeder::class
        ]);

        User::factory()->create([
            'email' => 'admin@example.com',
            'is_active' => 1,
        ]);

        Employee::factory(10)->create();
    }
}
