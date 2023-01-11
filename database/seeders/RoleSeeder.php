<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'student'
        ]);

        Role::create([
            'name' => 'staff'
        ]);

        Role::create([
            'name' => 'admin'
        ]);

        Role::create([
            'name' => 'approver'
        ]);

        Role::create([
            'name' => 'superadmin'
        ]);
    }
}
