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
            'approver' => '1'
        ]);

        Division::create([
            'name' => 'DKV',
            'approver' => '2'
        ]);

        Division::create([
            'name' => 'DI',
            'approver' => '2'
        ]);

        Division::create([
            'name' => 'BM',
            'approver' => '1'
        ]);
    }
}
