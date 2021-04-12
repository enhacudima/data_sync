<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comments;
use Auth;
use App\User;
use App\UserL;
use App\CountryStates;

class LocationController extends Controller
{

    public $key;
    public $x;
    public $y;
    public $z;
    public $location_id;
    public $user_id;
    public function __construct($user_id,$location_id, $x, $y, $z)
    {
        $this->middleware('auth:api');
        $this->key =  md5(time());
        $this->x =  $x;
        $this->y =  $y;
        $this->z =  $z;
        $this->location_id = $location_id;
        $this->user_id = $user_id;
        $this->create();

    }


    public function create()
    {
        $states = CountryStates::where('phone',$this->location_id)->first();
        UserL::updateOrCreate(

            [
            "key"=>$this->key,
            ],
            [
            "x"=>$this->x,
            "y"=>$this->y,
            "z"=>$this->z,
            "user_id" => $this->user_id,
            "location_id" => $states->id,
            ]

        );
        User::where('id',$this->user_id)->update(['location_id'=>$states->id]);
    }

    public function get()
    {
        $user = Auth::user()->id;
        return UserL::find($user);

    }

}
