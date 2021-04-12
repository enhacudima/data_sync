<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\UserV;
use App\CV;
use App\CVSchool;
use App\Meals;

class UserProfileController extends Controller
{

    public function __construct()
    {


    }

    public function UserProfile($token)
    {
        $data=Meals::with('mealCuisine','mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs','mealTags.tagName')
                    ->where('key',$token)->first();


        return response()->json($data, 200);
    }

}
