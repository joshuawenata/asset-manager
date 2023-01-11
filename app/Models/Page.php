<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public function RolePageMappings(){
        return $this->hasMany(RolePageMapping::class);
    }
//    1 diatas dah bener
}
