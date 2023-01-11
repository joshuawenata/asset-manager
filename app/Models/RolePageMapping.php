<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePageMapping extends Model
{
    use HasFactory;

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function page(){
        return $this->belongsTo(Page::class, 'page_id');
    }
//    2 above dah bener
}
