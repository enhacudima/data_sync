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
    	$data=Meals::with('mealUser','mealCategory','mealTags.tagName','mealOptions')->orderby('end_date','asc')->where('start_date', '<=', Now())->where('end_date', '>=', Now())->paginate(20);

        return response()->json($data, 200);
    }
    public function searchMeals($search)
    {
        $data=Meals::limit(20)
        ->userName($search)
        ->where(
           function($query) {
             return $query
                ->orwhere('name','like',"%".$search."%")
                ->orwhere('email','like',"%".$search."%")
                ->orwhere('phone','like',"%".$search."%")
                ->orwhere('location','like',"%".$search."%")
                ->orwhere('start_date','like',"%".$search."%")
                ->orwhere('end_date','like',"%".$search."%")
                ->orwhere('reference','like',"%".$search."%");
            })
        ->with('mealUser','mealCategory','mealTags.tagName','mealOptions')
        ->orderby('end_date','asc')
        ->where('start_date', '<=', Now())->where('end_date', '>=', Now())
        ->get();
    	return response()->json($data, 200);
    }


}
