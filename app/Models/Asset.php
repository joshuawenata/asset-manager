<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    public function assetcategory(){
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    public function division(){
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
//  3 diatas dah bener
}
