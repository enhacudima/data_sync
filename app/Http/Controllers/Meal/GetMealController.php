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
        //$this->middleware('role_or_permission:pub_create', ['only' => ['newMeal']]);
    }
    public function getAllMeals()
    {
    	$data=Meals::with('mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs')->get();
    	return response()->json($data, 200);
    }

    public function getMealsV2($currency_id)
    {
        $currency_id=$currency_id;
        $data=MealsAPI2::with('mealAllergies.allergiesIngredients','mealTags.tagName','mealOptions');
        $data=$this->selectCurrency($currency_id,$data)
        ->select('meal_v_api2.*','meal_prices.amount','currency.currency')
        ->distinct();
        $data=$data->get()->toArray();
        $dataRemove=([
            [
            'relaction'=>'meal_allergies',
            'subRelaction'=>'allergies_ingredients',
            'subRelaField'=>'name',
            'newArray'=>'allergies',
            ],
            [
            'relaction'=>'meal_tags',
            'subRelaction'=>'tag_name',
            'subRelaField'=>'name',
            'newArray'=>'tags',
            ],
            [
            'relaction'=>null,
            'subRelaction'=>'meal_options',
            'subRelaField'=>'name',
            'newArray'=>'options',
            ]
        ]);
        $remove= new RemoveRelections($data,$dataRemove);
        $data=$remove->readRelections();

        //$data=$this->readMelsRelections($data,$dataRemove);
    	return response()->json($data, 200);
    }

    public function selectCurrency($currency_id,$data){
        $data->leftjoin('meal_prices','meal_prices.meal_id','meal_v_api2.id')
             ->where('meal_prices.currency_id',$currency_id)
             ->where('meal_prices.status',1)
             ->leftjoin('currency','currency.id','meal_prices.currency_id');

        return $data;
    }

    public function getPagmMals()
    {
    	$data=Meals::where('user_id',Auth::user()->id)->with('mealCuisine','mealCategory','mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs')->orderby('end_date','asc')->paginate(20);

        return response()->json($data, 200);
    }
    public function searchMeals($search)
    {
        $data=Meals::limit(20)
        ->where('user_id',Auth::user()->id)
        ->where('name','like',"%".$search."%")
        ->orwhere('email','like',"%".$search."%")
        ->orwhere('phone','like',"%".$search."%")
        ->orwhere('location','like',"%".$search."%")
        ->orwhere('start_date','like',"%".$search."%")
        ->orwhere('end_date','like',"%".$search."%")
        ->with('mealCuisine','mealCategory','mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs')->orderby('end_date','asc')
        ->get();
    	return response()->json($data, 200);
    }

    public function getThisMeal ($idMeal)
    {
        $data=Meals::where('id',$idMeal)
        ->with('mealUser.userType','mealCategory','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs','mealTags.tagName','mealOptions')
        ->first();
    	return response()->json($data, 200);
    }


    public function getThisMealPrices($id){
        $data=MealPrices::where('meal_id',$id)->with('users','priceCurrency','priceStatus')->get();
        return response()->json($data, 200);
    }


    public function getMealType(){
        $data=MealType::get();
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
        $last=($last->created_at)->diffForHumans();


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

        $last=($last->created_at)->diffForHumans();


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
