<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\UserV;
class UserProfileController extends Controller
{

    public function __construct()
    {


    }

    public function UserProfile($token)
    {


        $data=UserV::where('key',$token)->first();



        return response()->json($data, 200);
    }

}
