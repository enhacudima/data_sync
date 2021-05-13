<?php

namespace App\Http\Controllers\Meal;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Meals;
use App\MealsAPI2;
use App\Http\Controllers\Helpers\RemoveRelectionController as RemoveRelections;
use App\Options;
use App\MealPrices;
use Auth;
use App\MealType;
use Carbon\Carbon;
class GetMealWelcomeController extends Controller
{


    public function getPagmMals()
    {
    	$data=Meals::with('mealCuisine','mealCategory','mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs','mealTags.tagName')->orderby('end_date','asc')->where('start_date', '<=', Now())->where('end_date', '>=', Now())->paginate(20);

        return response()->json($data, 200);
    }
    public function searchMeals($search)
    {
        $data=Meals::limit(20)
        ->where('name','like',"%".$search."%")
        ->orwhere('email','like',"%".$search."%")
        ->orwhere('phone','like',"%".$search."%")
        ->orwhere('location','like',"%".$search."%")
        ->orwhere('start_date','like',"%".$search."%")
        ->orwhere('end_date','like',"%".$search."%")
        ->with('mealCuisine','mealCategory','mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs')
        ->orderby('end_date','asc')
        ->where('start_date', '<=', Now())->where('end_date', '>=', Now())
        ->get();
    	return response()->json($data, 200);
    }


}
