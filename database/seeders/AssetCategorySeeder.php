<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssetCategory::create([
            'name' => 'Kamera',
            'status' => 1,
        ]);
        AssetCategory::create([
            'name' => 'Printer',
            'status' => 1,
        ]);
        AssetCategory::create([
            'name' => 'Mic',
            'status' => 1,
        ]);
    }
}
