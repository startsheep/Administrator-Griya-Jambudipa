<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyProfile::create([
            'name' => 'Griya Jambudipa',
            'email' => 'griyajambudipa@gmail.com',
            'phone' => '0222128912',
            'url' => url(''),
            'address' => 'Jalan Gandawijaya No.1 (Cimahi Tengah), Cimahi, Jawa Barat 40512, Indonesia.',
        ]);
    }
}
