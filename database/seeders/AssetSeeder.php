<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Asset::create([
            'serial_number' => 'SN1234',
            'status' => 'tersedia',
            'brand' => 'Canon',
            'assigned_location' => 'Prodi DI Lt.6',
            'current_location' => 'Prodi DI Lt.6',
            'division_id' => 3,
            'asset_category_id' => 1
        ]);

        Asset::create([
            'serial_number' => 'DF5754',
            'status' => 'tersedia',
            'brand' => 'Saramonic',
            'assigned_location' => 'SLSC Lt.6',
            'current_location' => 'SLSC Lt.6',
            'division_id' => 3,
            'asset_category_id' => 3
        ]);

        Asset::create([
            'serial_number' => 'AB7869',
            'status' => 'tersedia',
            'brand' => 'Nikon',
            'assigned_location' => 'Prodi DKV Lt.6',
            'current_location' => 'Prodi DKV Lt.6',
            'division_id' => 2,
            'asset_category_id' => 1
        ]);

        Asset::create([
            'serial_number' => 'GF4363',
            'status' => 'tersedia',
            'brand' => 'HP',
            'assigned_location' => 'Prodi DKV Lt.6',
            'current_location' => 'Prodi DKV Lt.6',
            'division_id' => 2,
            'asset_category_id' => 2
        ]);
    }
}
