<?php

namespace App\Http\Controllers\Meal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Meals;
use App\CV;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\SyncMealAllergies;
use App\SyncTags;
use App\Options;
use App\MealPrices;

class CreateMealController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('role_or_permission:meal_create', ['only' => ['newMeal']]);
    }

    public function newMeal(Request $request)
    {

    	$mealData=$request->data['mealData'];
        $tags=$request->data['tags'];
        $file_id=null;
        if(isset($request->data['fileData']['file_id'])){
            $file_id = $request->data['fileData']['file_id'];
        }
        $mealData['tags'] = $tags;
        $mealData['file_id'] = $file_id;

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($mealData);

        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:50|unique:meals,name',
            'alias' => 'required|string|max:255',
            'details' => 'required|string|max:255',
            'commonTiming'=>'required',
            'time' => 'required|numeric',
            'people' => 'required|numeric',
            'experience' => 'required|numeric|exists:experiences,id',
            'tags' => 'required',
            'file_id' => 'required|numeric',
            'mealType' => 'required|numeric',
        ],
        [
     	    'file_id.required'=>'Please add a picture of meal.'
        ]
    	);
    if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()], 422);
            }

    $input = $myRequest->all();
            $input['user_id'] = Auth::user()->id;
            $input['key'] = md5(time()).Auth::user()->id;

            $meal=Meals::Create(
            	[
                    'user_id'=> $input['user_id'],
                    'name'=> $input['name'],
                    'alias'=> $input['alias'],
            		'details' => $input['details'],
            		'common_timing_id' => $input['commonTiming'],
            		'time' => $input['time'],
            		'people' => $input['people'],
            		'experience_id' => $input['experience'],
            		'key' => $input['key'],
            		'cuisine_id' =>$input['cuisine'],
                    'type_meal_id'=>$input['mealType'],

            	]
            );


            $file = new FilesController;
            $file_id = $myRequest['file_id'];
            $file->useFile($file_id,$meal->id, 'meals', 0);

           foreach($input['ingredients'] as $key => $ingredient){
               //add ingredients to meal
               SyncMealAllergies::create([
                   'meal_id' => $meal->id ,
                   'ingredients_id' => $ingredient,
               ]);

           }


           foreach($input['options'] as $key => $option){
            //add options to meal
            $optiKey = md5(time()).Auth::user()->id;
            Options::updateOrInsert(
                [
                    'name' => $option,
                    'meal_id' =>$meal->id,
                ],
                [
                    'user_id'=> $input['user_id'],
                    'key' => $optiKey
                ]
            );

            }


           if(isset($tags)){
               $tagKey = md5(time()).Auth::user()->id;
               foreach($tags as $key => $tag){
                    SyncTags::create([
                        'tag_id' => $tag,
                        'meal_id' => $meal->id,
                        'user_id'=> $input['user_id'],
                        'key' => $tagKey
                    ]);
               }
           }


    return response()->json(['success'=>'Added new records.'], 200);
    }

    public function addprices(Request $request,$idMeal)
    {
        $priceData=$request->data['priceData'];
        $priceData['currency'] = $priceData['currency']['id'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($priceData);
        $validator = Validator::make($myRequest->all(), [
            'price' => 'required|numeric',
            'currency' => 'required|numeric|exists:currency,id',
        ],
        [
     	    'currency.numeric'=>'please select a valid currency.',
            'currency.exists'=>'please select a valid currency.'
        ]
    	);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }
        $oldMel=MealPrices::where('currency_id',$myRequest->currency)->where('meal_id',$idMeal)->where('amount',$myRequest->price)->first();
        if($oldMel){
            return response()->json(['errors'=>['You cannot override a same price']], 422);
        }
        MealPrices::where('currency_id',$myRequest->currency)->where('meal_id',$idMeal)
                ->update([
                    'status'=>0
                ]);

        MealPrices::create([
            'currency_id' => $myRequest->currency,
            'meal_id' => $idMeal,
            'amount'=> $myRequest->price,
            'key'=> md5(time()).Auth::user()->id,
            'user_id'=>Auth::user()->id,
        ]);





        return response()->json(['success'=>'Added new records.'], 200);
    }

    public function pricesStatus(Request $request, $status)
    {
        $priceData=$request->data['priceStatusData'];
        if($status=="false"){
            foreach($priceData as $key => $price){
                MealPrices::where('key',$price['key'])
                ->update([
                    'status'=>0
                ]);
            }

        }else{
            foreach($priceData as $key => $price){
                MealPrices::where('currency_id',$price['currency_id'])->where('meal_id',$price['meal_id'])
                ->update([
                    'status'=>0
                ]);

                MealPrices::where('key',$price['key'])
                ->update([
                    'status'=>1
                ]);
            }
        }
        return response()->json(['success'=>'Added new records.'], 200);
    }


}
