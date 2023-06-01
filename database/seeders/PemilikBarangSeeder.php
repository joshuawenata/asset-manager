<?php

namespace Database\Seeders;

use App\Models\PemilikBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'nama' => 'joshua',
            'division_id' => 5
        ]);
    }
}
