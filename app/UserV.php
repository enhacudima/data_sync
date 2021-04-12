<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserV extends Model
{

    protected $table = 'users_v';

    protected $fillable = [
        'name', 'email','lastName','dataBrith','phone1','prefix_phone_1','userName','type','status','prefix_id', 'key','mode','location_id','fullAddr','country',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];



}
