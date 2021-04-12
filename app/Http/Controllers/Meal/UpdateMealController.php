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

class UpdateMealController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function updateMeal(Request $request,$id)
    { 

    	$mealData=$request->data['mealData'];
        $tags=$request->data['tags'];
        $file_id=null;
        if(isset($request->data['fileData']['file_id'])){
            $file_id = $request->data['fileData']['file_id']; 
        }
        $mealData['tags'] = $tags; 
        $mealData['file_id'] = $file_id;
        $mealData['id'] =$id;

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($mealData);

        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:50|unique:meals,name,'.$id.',id',
            'alias' => 'required|string|max:255',
            'details' => 'required|string|max:255',
            'commonTiming'=>'required',
            'time' => 'required|numeric',
            'people' => 'required|numeric', 
            'experience' => 'required|numeric|exists:experiences,id',
            'tags' => 'required', 
            //'file_id' => 'required|numeric',
            'mealType' => 'required|numeric',
            'id' =>'required|numeric|exists:meals,id',
        ],
        [
     	    'file_id.required'=>'Please add a picture of meal.',
            'id.required'=>"This meal don't exist.",
            'id.numeric'=>"This meal don't exist.",
            'id.required'=>"This meal don't exist.",
        ]
    	);
    if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()->all()], 422);            
            } 

    $input = $myRequest->all(); 
            $input['user_id'] = Auth::user()->id; 

            $meal=Meals::where('id',$id)
                ->update(
            	[
                    'user_id'=> $input['user_id'],
                    'name'=> $input['name'],
                    'alias'=> $input['alias'],
            		'details' => $input['details'],
            		'common_timing_id' => $input['commonTiming'],
            		'time' => $input['time'],
            		'people' => $input['people'],
            		'experience_id' => $input['experience'],
            		'cuisine_id' =>$input['cuisine'],
                    'type_meal_id'=>$input['mealType'],

            	]
            );

            if($file_id){        
                $file = new FilesController; 
                $file_id = $myRequest['file_id'];      
                $file->useFile($file_id,$id, 'meals', 0);
            }
            SyncMealAllergies::where('meal_id',$id)->delete();
            foreach($input['ingredients'] as $key => $ingredient){
               //add ingredients to meal
               SyncMealAllergies::create([
                   'meal_id' => $id ,
                   'ingredients_id' => $ingredient,
               ]);

            }

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
