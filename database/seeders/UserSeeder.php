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
            'name' => 'Joshua Wenata Sunarto',
            'email' => 'joshua.sunarto@binus.ac.id',
            'password' => bcrypt('12345'),
            'binusianid' => 'BN0014352432',
            'phone' => '082543356234',
            'address' => 'Jl. Everywhere No.110',
            'division_id' => '3',
            'role_id' => '2',
            'active_status' => 1,
        ]);

        User::create([
            'name' => 'LB003',
            'email' => 'lb003@binus.edu',
            'password' => bcrypt('12345'),
            'binusianid' => 'BN8345345865',
            'phone' => '081345634543',
            'address' => 'Jl. Panjaitan No.56',
            'division_id' => '3',
            'role_id' => '3',
            'active_status' => 1,
        ]);

        User::create([
            'name' => 'Siska',
            'email' => 'siska.novianti@binus.edu',
            'password' => bcrypt('12345'),
            'binusianid' => 'BN83453451865',
            'phone' => '081345634543',
            'address' => 'Jl. Panjaitan No.56',
            'division_id' => '4',
            'role_id' => '3',
            'active_status' => 1,
        ]);

        User::create([
            'name' => 'Maria Auleria',
            'email' => 'joshua.sunarto@binus.edu',
            'password' => bcrypt('12345'),
            'binusianid' => 'BN835638546',
            'phone' => '08145635438',
            'address' => 'Jl. Sunda No.5',
            'division_id' => '3',
            'role_id' => '4',
            'active_status' => 1,
        ]);

        User::create([
            'name' => 'Dummy Staff',
            'email' => 'dummy.staff@binus.edu',
            'password' => bcrypt('12345'),
            'binusianid' => 'BNDUMMY',
            'phone' => '08111111',
            'address' => 'Jl. Dummy No.5',
            'division_id' => '3',
            'role_id' => '2',
            'active_status' => 1,
        ]);

        User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@super.co',
            'password' => bcrypt('12345'),
            'binusianid' => null,
            'phone' => null,
            'address' => null,
            'division_id' => null,
            'role_id' => '5',
            'active_status' => 1,
        ]);

        //daftar student => maria.auleria@binus.ac.id
        //daftar staff => maria.auleria@binus.edu
    }
}
