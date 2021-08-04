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
use Illuminate\Database\Eloquent\Builder;
class GetMealWelcomeController extends Controller
{


    public function getPagmMals()
    {
    	$data=Meals::with('mealUser','mealCategory','mealTags.tagName','mealOptions')
        ->orderby('end_date','asc')->where('start_date', '<=', Now())
        ->where('end_date', '>=', Now())
        ->paginate(50);

        return response()->json($data, 200);
    }
    public function searchMeals($search)
    {
        $data=Meals::

        where(
           function($query) use ($search) {
             return $query
                ->orwhere('name','like',"%".$search."%")
                ->orwhere('email','like',"%".$search."%")
                ->orwhere('phone','like',"%".$search."%")
                ->orwhere('location','like',"%".$search."%")
                ->orwhere('start_date','like',"%".$search."%")
                ->orwhere('end_date','like',"%".$search."%")
                ->orwhere('reference','like',"%".$search."%")
                ->orwhereHas('mealUser', function ($query) use ($search){
                    $query->where('name', 'like', '%'.$search.'%')
                          ->orwhere('lastName', 'like', '%'.$search.'%')
                          ->orwhere('email', 'like', '%'.$search.'%');
                })
                ->orwhereHas('mealCategory', function ($query) use ($search){
                    $query->where('title', 'like', '%'.$search.'%');
                });
            })

        ->with(['mealUser','mealCategory','mealTags.tagName','mealOptions'])
        ->orderby('end_date','asc')
        ->where('start_date', '<=', Now())->where('end_date', '>=', Now())
        ->paginate(50);
    	return response()->json($data, 200);
    }


}
