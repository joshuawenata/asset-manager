<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'superadmin',
            'email' => 'inventory.bdg@binus.edu',
            'password' => bcrypt('C)5I*:xNGXmh'),
            'binusianid' => null,
            'phone' => null,
            'division_id' => null,
            'role_id' => '4',
            'active_status' => 1,
        ]);

    }
}
