<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'binusianid',
        'address',
        'phone',
        'active_status',
        'division_id',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function division(){
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function requests(){
        return $this->hasMany(Request::class);
    }
//    3 above dah bener

//    protected function role_type(): Attribute{
//        return new Attribute(
//            get: fn ($value) => ["student", "staff", "admin", "approver", "superadmin"][$value],
//        );
//    }

    public function getAtasan($track_approver, $atasan){

//        $divisi = Booking::where('request_id', $req_id)->first();
//        $atasan = $divisi->asset->division->id;

        if($track_approver == 1){
            $atasan = User::where('division_id', $atasan)->where('role_id', '3')->first()->name;
        }
        else if ($track_approver == 0){
            $atasan = User::where('division_id', $atasan)->where('role_id', '4')->first()->name;
        }

        return $atasan;
    }

    public static function getRolePage(){
        if(Auth::user()->role->name == 'student'){
            return 'createRequest';
        }
        elseif (Auth::user()->role->name == 'staff'){
            return 'chooseDivision';
        }
    }
}
