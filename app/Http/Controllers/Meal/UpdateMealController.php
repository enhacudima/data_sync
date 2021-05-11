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
use App\Http\Controllers\Subscriptions\PlansController;

class UpdateMealController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function updateMeal(Request $request,$id)
    {
        $plan = new PlansController();
        $checkPlan =$plan->checkAnyUserPlan(Auth::user()->id);
        if(!$checkPlan){
            return response()->json(['errors'=>["Voce não esta subscrito a nenhum plano."]], 422);
        }

        $checkPlan = $plan->recordFeatureUsageHelper(Auth::user()->id,'posts',1,'usage');

        $checkPlan = $plan->checkAnyUserPlanCan(Auth::user()->id,'posts');
        if(!$checkPlan){
            return response()->json(['errors'=>["You have exceeded the number of publications, subscribe to a plan according to your needs."]], 422);
        }




    	$mealData=$request->data['mealData'];
        $tags=$request->data['tags'];
        $file_id=null;
        if(isset($request->data['fileData']['file_id'])){
            $file_id = $request->data['fileData']['file_id'];
        }

        if(!isset($request->data['web'])){
            $mealData['web'] = null;
        }

        if(!isset($request->data['location'])){
            $mealData['location'] = null;
        }

        if(!isset($request->data['phone'])){
            $mealData['phone'] = null;
        }

        $mealData['tags'] = $tags;
        $mealData['file_id'] = $file_id;
        $mealData['id'] =$id;

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($mealData);

        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'web' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|numeric',
            'details' => 'required|string',
            'commonTiming'=>'required',
            'experience' => 'required|numeric|exists:experiences,id',
            'tags' => 'nullable',
            'id' =>'required|numeric|exists:meals,id',
        ],
        [
     	    'file_id.required'=>'Please add a pdf file.',
            'id.required'=>"This publicidade don't exist.",
            'id.numeric'=>"This publicidade don't exist.",
            'id.required'=>"This publicidade don't exist.",
        ]
    	);
    if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()], 422);
            }

    $input = $myRequest->all();
            $input['user_id'] = Auth::user()->id;

            //start date
            $startDate=new Carbon($input['commonTiming'][0]);
            $startDate=$startDate->format('Y-m-d H:i:s');
            //end date
            $endDate=new Carbon($input['commonTiming'][1]);
            $endDate=$endDate->format('Y-m-d H:i:s');


            $meal=Meals::where('id',$id)
                ->update(
            	[
                    //'user_id'=> $input['user_id'],
                    'name'=> $input['name'],
                    'email'=> $input['email'],
            		'details' => $input['details'],
            		'start_date' => $startDate,
            		'end_date' => $endDate,
            		'location' => $input['location'],
            		'web' => $input['web'],
            		'experience_id' => $input['experience'],
                    'phone'=>$input['phone'],

            	]
            );

            if($file_id){
                $file = new FilesController;
                $file_id = $myRequest['file_id'];
                $file->useFile($file_id,$id, 'meals', 0);
            }
            /*
            SyncMealAllergies::where('meal_id',$id)->delete();

            foreach($input['ingredients'] as $key => $ingredient){
               //add ingredients to meal
               SyncMealAllergies::create([
                   'meal_id' => $id ,
                   'ingredients_id' => $ingredient,
               ]);

            }*/

            Options::where('meal_id',$id)->delete();
           foreach($input['options'] as $key => $option){
            //add options to meal
            $optiKey = md5(time()).Auth::user()->id;
            Options::updateOrInsert(
                [
                    'name' => $option,
                    'meal_id' =>$id,
                ],
                [
                    'user_id'=> $input['user_id'],
                    'key' => $optiKey
                ]
            );

            }

            SyncTags::where('meal_id',$id)->delete();
           if(isset($tags)){
               $tagKey = md5(time()).Auth::user()->id;
               foreach($tags as $key => $tag){
                    SyncTags::create([
                        'tag_id' => $tag,
                        'meal_id' => $id,
                        'user_id'=> $input['user_id'],
                        'key' => $tagKey
                    ]);
               }
           }


    return response()->json(['success'=>'updated records.'], 200);
    }


}
