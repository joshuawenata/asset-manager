<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'status',
        'brand',
        'current_location',
        'pemilik_barang',
        'division_id',
        'asset_category_id'
    ];

    public function assetcategory(){
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    public function division(){
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function repairAssets(){
        return $this->hasMany(RepairAsset::class);
    }

    public function assetLocation(){
        return$this->hasMany(assetLocation::class);
    }
    //  5 diatas dah bener

    public function getNamaPeminjam($id_aset){
        $b = Asset::find($id_aset)->bookings->whereNotNull('taken_date')->whereNull('realize_return_date')->first()->request->User->name;
        return $b;
    }
}
