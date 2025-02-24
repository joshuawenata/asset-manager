<?php

namespace Database\Seeders;

use App\Models\PemilikBarang;
use Illuminate\Database\Seeder;

class PemilikBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PemilikBarang::create([
            'nama' => 'Joshua',
            'division_id' => 6
        ]);
    }
}
