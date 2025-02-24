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
            'password' => bcrypt('ITb4ndung'),
            'binusianid' => null,
            'phone' => null,
            'division_id' => null,
            'role_id' => '4',
            'active_status' => 1,
        ]);

        User::create([
            'name' => 'Joshua',
            'email' => 'joshua.sunarto@binus.ac.id',
            'password' => bcrypt('12345678'),
            'binusianid' => 'BN124431900',
            'phone' => '083843058695',
            'division_id' => 6,
            'role_id' => '1',
            'active_status' => 1,
            'isStaff' => 1,
            'isAdmin' => 1,
            'isApprover' => 1,
        ]);

    }
}
