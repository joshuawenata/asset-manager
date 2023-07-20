<?php

namespace App\Imports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;
use App\Models\AssetCategory;
use App\Models\HistoryAddAsset;

class AssetsImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $asset_category = DB::table('asset_categories')->where('name', $row[4])->first();

        $history = new HistoryAddAsset();
        $history->user_id = \Illuminate\Support\Facades\Auth::user()->id;
        $history->aksi = \Illuminate\Support\Facades\Auth::user()->name." menambahkan barang dengan nomor seri ".$row[0];
        $history->save();

        return new Asset([
            'serial_number'      => $row[0],
            'status'             => 'tersedia',
            'brand'              => $row[1],
            'current_location'   => $row[2],
            'pemilik_barang'     => $row[3],
            'division_id'        => \Illuminate\Support\Facades\Auth::user()->division->id,
            'asset_category_id'  => $asset_category ? $asset_category->id : null,
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

}