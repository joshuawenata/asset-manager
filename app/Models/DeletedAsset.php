<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedAsset extends Model
{
    use HasFactory;

    public function assetcategory(){
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    public function division(){
        return $this->belongsTo(Division::class, 'division_id');
    }
//    2 diatas dah bener
}
