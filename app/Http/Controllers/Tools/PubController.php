<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\UserV;
use App\CV;
use App\CVSchool;
use App\Meals;
use Illuminate\Http\Request;
use App\Read;

class PubController extends Controller
{

    public function __construct()
    {


    }


    public function pub(Request $request, $token)
    {


        $data=Meals::with('mealUser','mealCategory','mealTags.tagName','mealOptions')
                    ->where('key',$token)->first();




        if(Read::where('pub_key', $token )->exists()){
        }else{
            $result=Read::make($token);
            if(isset($data)){
                $view=$data->views;
                $view=++$view;
                $data->views=$view;
                $data->save();
            }

        }




        return response()->json($data, 200);
    }

}
