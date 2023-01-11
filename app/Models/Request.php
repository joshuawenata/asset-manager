<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public function User(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
//  2 diatas dah bener
}
