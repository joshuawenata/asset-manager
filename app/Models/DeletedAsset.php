<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedAsset extends Model
{
    use HasFactory;

    public function assetJenis(){
        return $this->belongsTo(AssetJenis::class, 'asset_jenis_id');
    }

    public function division(){
        return $this->belongsTo(Division::class, 'division_id');
    }
//    2 diatas dah bener
}
