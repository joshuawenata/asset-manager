<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetJenis extends Model
{
    use HasFactory;

    public function assets(){
        return $this->hasMany(Asset::class);
    }

    public function deletedassets(){
        return $this->hasMany(DeletedAsset::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
