<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comments;
use Auth;
use App\User;
use App\UserC;

class BackUpUserController extends Controller
{
     
    public $key;
    public function __construct($key)
    {
        $this->middleware('auth:api');
        $this->key =  $key;
        $this->clone();
        
    }
    

    public function clone()
    {
        $user= User::where('key',$this->key)->first()->toArray();
        
        $user['user_id'] = Auth::user()->id; 

        $newUser = new UserC();
        $newUser->create($user);

    }

}
