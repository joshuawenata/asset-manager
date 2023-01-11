<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class);
    }

    public function assets(){
        return $this->hasMany(Asset::class);
    }

    public function deletedassets(){
        return $this->hasMany(DeletedAsset::class);
    }
//    3 diatas dah bener
}
