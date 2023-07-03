<?php

namespace Database\Seeders\Geo;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = \App\Models\Geo\Province::factory()->createMany([['name'=>'Jawa Barat'],['name'=>'Jawa Timur'],['name'=>'DI Yogyakarta']]);
    }
}
