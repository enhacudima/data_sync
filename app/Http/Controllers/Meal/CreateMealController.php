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
        //$this->middleware('role_or_permission:pub_create', ['only' => ['newMeal']]);
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
            'file_id' => 'required|numeric',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'web' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|numeric',
            'details' => 'required|string|max:255',
            'commonTiming'=>'required',
            'experience' => 'required|numeric|exists:experiences,id',
            'tags' => 'required',
        ],
        [
     	    'file_id.required'=>'Please add PDF file.'
        ]
    	);
    if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()], 422);
            }

    $input = $myRequest->all();
            $input['user_id'] = Auth::user()->id;
            $input['key'] = md5(time()).Auth::user()->id;


            //start date
            $startDate=new Carbon($input['commonTiming'][0]);
            $startDate=$startDate->format('Y-m-d H:i:s');
            //end date
            $endDate=new Carbon($input['commonTiming'][1]);
            $endDate=$endDate->format('Y-m-d H:i:s');

            $meal=Meals::Create(
            	[
                    'user_id'=> $input['user_id'],
                    'name'=> $input['name'],
                    'email'=> $input['email'],
            		'details' => $input['details'],
            		'start_date' => $startDate,
            		'end_date' => $endDate,
            		'location' => $input['location'],
            		'web' => $input['web'],
            		'experience_id' => $input['experience'],
            		'key' => $input['key'],
                    'phone'=>$input['phone'],

            	]
            );


            $file = new FilesController;
            $file_id = $myRequest['file_id'];
            $file->useFile($file_id,$meal->id, 'meals', 0);

          /* foreach($input['ingredients'] as $key => $ingredient){
               //add ingredients to meal
               SyncMealAllergies::create([
                   'meal_id' => $meal->id ,
                   'ingredients_id' => $ingredient,
               ]);

           }*/


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
