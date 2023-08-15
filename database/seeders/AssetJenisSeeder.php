<?php

namespace Database\Seeders;

use App\Models\AssetJenis;
use Illuminate\Database\Seeder;

class AssetJenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssetJenis::create([
            'name' => 'Kamera',
            'status' => 1,
        ]);
        AssetJenis::create([
            'name' => 'Printer',
            'status' => 1,
        ]);
        AssetJenis::create([
            'name' => 'Mic',
            'status' => 1,
        ]);
    }
}
