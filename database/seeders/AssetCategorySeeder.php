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
            'name' => 'Kamera'
        ]);
        AssetCategory::create([
            'name' => 'Printer'
        ]);
        AssetCategory::create([
            'name' => 'Mic'
        ]);
    }
}
