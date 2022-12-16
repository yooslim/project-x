<?php

namespace Database\Seeders;

use Domains\Authentication\Database\Seeders\UserTableSeeder;
use Domains\Location\Database\Seeders\CityTableSeeder;
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
        $this->call(UserTableSeeder::class);
        $this->call(CityTableSeeder::class);
    }
}
