<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Experiences;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\ExperiencesSync;

class ExperienceController extends Controller
{
         
    public function __construct()
    {
        $this->middleware('auth:api');
        
    }
    

    public function create(Request $request)
    { 
    	$experienceData=$request->data['experienceData'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($experienceData);

        $validator = Validator::make($myRequest->all(), [
            'title' => 'required|string|max:255|unique:experiences,title',
            'range' => 'required',
            'ref' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ],
        [
     	
        ]
    	);
    if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()->all()], 422);            
            } 
  
    $input = $myRequest->all(); 
    $input['user_id'] = Auth::user()->id; 
    $input['key'] = md5(time()).Auth::user()->id;
    $input['experience_from'] = $myRequest->range[0];
    $input['experience_to'] = $myRequest->range[1];

            $experiences=Experiences::Create(
            	[
            		'user_id'=> $input['user_id'],
            		'key' => $input['key'],
                    'title' => $input['title'],
                    'experience_from' => $input['experience_from'],
                    'experience_to' => $input['experience_to'],
                    'ref' => $input['ref'],
                    'description' =>$input['description']
            	]
            );

    $this->syncExperience($experiences);

    return response()->json(['success'=>'Added new records.'], 200); 
    }

    public function syncExperience($experiences)
    {
        $experiencesTemp = Experiences::where('experience_from','>=',$experiences->experience_from)->where('experience_to','<=',$experiences->experience_to)->get();
        ExperiencesSync::where('experiences_id',$experiences->id)->delete();
        foreach($experiencesTemp as $key => $experience){
            ExperiencesSync::Create(
            	[
            		'user_id'=> $experiences->user_id,
                    'experiences_id' => $experiences->id,
                    'experiences_sync_id' => $experience->id,
            	]
            );

        }
    }



    public function Status(Request $request, $status)
    {
        $experienceStatusData=$request->data['experienceStatusData'];
        if($status=="false"){
            foreach($experienceStatusData as $key => $experienceStatus){
                Experiences::where('key',$experienceStatus['key'])
                ->update([
                    'status'=>0
                ]);
            }

        }else{
            foreach($experienceStatusData as $key => $experienceStatus){
                Experiences::where('key',$experienceStatus['key'])
                ->update([
                    'status'=>1
                ]);
            }
        }
        return response()->json(['success'=>'Update records.'], 200);
    }

    
    public function update(Request $request,$key)
    { 
    	$experienceData=$request->data['experienceData'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($experienceData);

        $validator = Validator::make($myRequest->all(), [
            'title' => 'required|string|max:255|unique:experiences,title,'.$key.',key',
            'range' => 'required',
            'ref' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ],
        [
     	
        ]
    	);
    if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()->all()], 422);            
            } 
  
    $input = $myRequest->all(); 
    $input['user_id'] = Auth::user()->id; 
    $input['experience_from'] = $myRequest->range[0];
    $input['experience_to'] = $myRequest->range[1];

            $experiences=Experiences::where('key',$key)
            ->update(
            	[
            		'user_id'=> $input['user_id'],
                    'title' => $input['title'],
                    'experience_from' => $input['experience_from'],
                    'experience_to' => $input['experience_to'],
                    'ref' => $input['ref'],
                    'description' =>$input['description']
            	]
            );
    $experiences=Experiences::where('key',$key)->first();

    $this->syncExperience($experiences);

    return response()->json(['success'=>'Added new records.'], 200); 
    }


}
