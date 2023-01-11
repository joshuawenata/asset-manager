<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public function request(){
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function asset(){
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function assetcategory(){
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }
//    3 diatas dah bener
}
