<?php

namespace App\Imports;

use App\Models\Asset;
use App\Http\Controllers\AssetLocationController;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;
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
        $asset_jenis = DB::table('asset_jenis')->where('name', $row[3])->first();

        $history = new HistoryAddAsset();
        $history->user_id = \Illuminate\Support\Facades\Auth::user()->id;
        $history->aksi = \Illuminate\Support\Facades\Auth::user()->name . " menambahkan barang dengan nomor seri " . $row[0] . ", lokasi " . $row[1] . ", pemilik barang " . $row[2] . ", jenis barang " . $asset_jenis->name . ", kategori barang " . $row[4] . ", spesifikasi barang " . $row[5] . ", brand " . $row[6] . ", status barang " . $row[7] . ", divisi barang " . DB::table('divisions')->where('id', \Illuminate\Support\Facades\Auth::user()->division_id)->get();
        $history->save();

        $aset = new Asset;

        $aset->kategori_barang = $row[4];
        $aset->spesifikasi_barang = $row[5];
        $aset->serial_number = $row[0];
        $aset->current_location = $row[1] < 1000 ? "0" . $row[1] : $row[1];
        $aset->pemilik_barang = $row[2];
        $aset->brand = $row[6];
        $aset->status = $row[7];
        $aset->division_id = \Illuminate\Support\Facades\Auth::user()->division_id;
        $aset->asset_jenis_id = $asset_jenis ? $asset_jenis->id : null;

        $aset->save();

        $this->storeLoc();

        return null;

    }

    public function startRow(): int
    {
        return 2;
    }

    public function storeLoc()
    {
        $aset = Asset::max('id');
        $aset = Asset::find($aset);
        $save_loc = new AssetLocationController();
        $save_loc->initialize($aset);
    }

}
