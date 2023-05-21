<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Division::create([
            'name' => 'IT',
            'role_id' => '1',
            'approver' => '1'
        ]);

        Division::create([
            'name' => 'DKV',
            'role_id' => '1',
            'approver' => '2'
        ]);

        Division::create([
            'name' => 'DI',
            'role_id' => '1',
            'approver' => '2'
        ]);

        Division::create([
            'name' => 'CP',
            'role_id' => '1',
            'approver' => '2'
        ]);

        Division::create([
            'name' => 'BM',
            'role_id' => '2',
            'approver' => '1'
        ]);
    }
}
