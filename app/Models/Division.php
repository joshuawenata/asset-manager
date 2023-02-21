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

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function request(){
        return $this->hasMany(Division::class);
    }
//    4 diatas dah bener

    public static function getName($id){
        $div = Division::find($id);
        return $div->name;
    }
}
