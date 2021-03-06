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
use DB;
use App\Read;

class GetMealController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('role_or_permission:pub_get');
    }
    public function getAllMeals()
    {
    	$data=Meals::with('mealUser','mealCategory','mealTags.tagName','mealOptions')->get();
    	return response()->json($data, 200);
    }


    public function getPagmMals()
    {
    	if(Auth::user()->can('pub_get_all')){
            $data=Meals::with('mealUser','mealCategory','mealTags.tagName','mealOptions')->orderby('end_date','asc')->paginate(50);
        }else{

            $data=Meals::where('user_id',Auth::user()->id)->with('mealUser','mealCategory','mealTags.tagName','mealOptions')->orderby('end_date','asc')->paginate(50);
        }

        return response()->json($data, 200);
    }
    public function searchMeals($search)
    {

        $data=Meals::where(
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

        if(!Auth::user()->can('pub_get_all')){
            $data->where('user_id',Auth::user()->id);

        }
        $data->paginate(50);

    	return response()->json($data, 200);
    }

    public function getThisMeal ($idMeal)
    {
        $data=Meals::where('id',$idMeal)
        ->with('mealUser','mealCategory','mealTags.tagName','mealOptions','mealFile')
        ->first();
    	return response()->json($data, 200);
    }




    public function getPosts(){
        $date=Carbon::now();
        $data=Meals::whereYear('created_at','=',$date->format('Y'))
        ->select(DB::raw('count(*) as value'), DB::raw("DATE_FORMAT(created_at, '%m')  month"))
        ->groupby('month')
        ->get();

        $last =Meals::latest()->first();
        $last=($last->created_at)->diffForHumans();


        return response()->json(["data"=>$data,"last"=>$last], 200);
    }
    public function getPost(){
        $date=Carbon::now();
        $data=Meals::whereYear('created_at','=',$date->format('Y'))
        ->select(DB::raw('count(*) as value'), DB::raw("DATE_FORMAT(created_at, '%m')  month"))
        ->groupby('month')
        ->where('user_id',Auth::user()->id)
        ->get();

        $last =Meals::where('user_id',Auth::user()->id)->latest()->first();
        if(isset($last)){
            $last=($last->created_at)->diffForHumans();
        }else{
            $last=null;
        }


        return response()->json(["data"=>$data,"last"=>$last], 200);
    }


    public function getPostRead(){
        $date=Carbon::now();
        $data=Read::join('meals','meals.key','read.pub_key')
        ->whereYear('read.created_at','=',$date->format('Y'))
        ->where('meals.user_id',Auth::user()->id)
        ->select(DB::raw("count('read.*') as value"), DB::raw("DATE_FORMAT(read.created_at, '%m')  month"))
        ->groupby('month')
        ->get();

        $last =Read::join('meals','meals.key','read.pub_key')
        ->where('meals.user_id',Auth::user()->id)
        ->select('read.created_at')
        ->latest('read.created_at')
        ->first();
        if(isset($last)){
        $last=($last->created_at)->diffForHumans();
        }else{
            $last=null;
        }


        return response()->json(["data"=>$data,"last"=>$last], 200);
    }


    public function getPostsReads(){
        $date=Carbon::now();
        $data=Read::
        whereYear('read.created_at','=',$date->format('Y'))
        ->select(DB::raw("count('read.*') as value"), DB::raw("DATE_FORMAT(read.created_at, '%m')  month"))
        ->groupby('month')
        ->get();

        $last =Read::
        select('read.created_at')
        ->latest('read.created_at')
        ->first();

        $last=($last->created_at)->diffForHumans();


        return response()->json(["data"=>$data,"last"=>$last], 200);
    }

}
