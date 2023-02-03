<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class);
    }

    public function RolePageMappings(){
        return $this->hasMany(RolePageMapping::class);
    }

    public function divisions(){
        return $this->hasMany(Division::class);
    }
//    3 above dah bener
}
