<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetLocation extends Model
{
    use HasFactory;

    public function asset(){
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
