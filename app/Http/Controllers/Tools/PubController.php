<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\UserV;
use App\CV;
use App\CVSchool;
use App\Meals;

class PubController extends Controller
{

    public function __construct()
    {


    }

    public function pub($token)
    {


        $data=Meals::with('mealCuisine','mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs','mealTags.tagName')
                    ->where('key',$token)->first();
        //add IP

        if($data){
           $view=$data->views;
           $view=++$view;
           $data->views=$view;
           $data->save();
        }


        return response()->json($data, 200);
    }

}
