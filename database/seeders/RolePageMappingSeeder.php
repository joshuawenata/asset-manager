<?php

namespace Database\Seeders;

use App\Models\RolePageMapping;
use Illuminate\Database\Seeder;

class RolePageMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RolePageMapping::create([
            'role_id' => '1',
            'page_id' => '1'
        ]);

        RolePageMapping::create([
            'role_id' => '3',
            'page_id' => '2'
        ]);

        RolePageMapping::create([
            'role_id' => '5',
            'page_id' => '3'
        ]);

        RolePageMapping::create([
            'role_id' => '4',
            'page_id' => '4'
        ]);
    }
}
