<?php

namespace Database\Seeders;

use App\Models\AssetLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssetLocation::create([
            'asset_id' => 1,
            'to_location' => 'Prodi DI Lt.6',
            'responsible' => 'auto-generated',
            'responsible_id' => 0,
            'notes' => 'Aset baru masuk'
        ]);

        AssetLocation::create([
            'asset_id' => 2,
            'to_location' => 'SLSC Lt.6',
            'responsible' => 'auto-generated',
            'responsible_id' => 0,
            'notes' => 'Aset baru masuk'
        ]);

        AssetLocation::create([
            'asset_id' => 3,
            'to_location' => 'Prodi DKV Lt.6',
            'responsible' => 'auto-generated',
            'responsible_id' => 0,
            'notes' => 'Aset baru masuk'
        ]);

        AssetLocation::create([
            'asset_id' => 4,
            'to_location' => 'Prodi DKV Lt.6',
            'responsible' => 'auto-generated',
            'responsible_id' => 0,
            'notes' => 'Aset baru masuk'
        ]);
    }
}
