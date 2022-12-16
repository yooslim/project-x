<?php

namespace Domains\Authentication\Database\Seeders;

use Domains\Authentication\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Test User',
            'email'  => 'test@live.fr',
            'password' => bcrypt('test'),
            'email_verified_at' => now(),
        ]);

        User::factory(10)->create();
    }
}
