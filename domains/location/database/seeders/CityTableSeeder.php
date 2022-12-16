<?php

namespace Domains\Location\Database\Seeders;

use Domains\Location\Models\City;
use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::factory(20)->create();
    }
}
