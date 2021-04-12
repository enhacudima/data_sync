<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Yadahan\AuthenticationLog\AuthenticationLogable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;
    use HasRoles;
    use AuthenticationLogable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard_name = 'api';
    protected $appends = ['permissions'];

    protected $fillable = [
        'name', 'email','locale', 'password','lastName','dataBrith','province','postalCode','phone1','prefix_phone_1','userName','type','status','prefix_id', 'key','mode','location_id','fullAddr',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


        public function userType()
    {
        return $this->belongsTo('App\UsersType','type','id');
    }


        public function userLocation()
    {
        return $this->belongsTo('App\CountryStates','location_id','id');
    }


    public function userLocations()
    {
        return $this->hasMany('App\UserL','location_id','location_id');
    }


    public function getPermissionsAttribute()
    {
        return $this->roles->map(function ($role) {
            return $role->permissions;
        })->collapse()->pluck('name')->unique()->values();
    }

    public function notifyAuthenticationLogVia()
    {
        return [ 'mail'];
    }
}
