<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Http\Controllers\Helpers\FilesController;

class AbilitiesController extends Controller
{


    public function __construct()
    {

    }

    public function abilities()
    {

        if (Auth::guard('api')->check()) {
            $permissions = Auth::guard('api')->user()->getPermissionsAttribute();
            $locale = Auth::guard('api')->user()->locale;
        }else{
            $permissions = [];
            $locale = 'en';
        }
        return response()->json(['permissions'=>$permissions,'locale'=>$locale],200);
    }

}
