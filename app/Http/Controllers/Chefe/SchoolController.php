<?php

namespace App\Http\Controllers\Chefe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CVSchool;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class SchoolController extends Controller
{
     public $user_id; 
    
    public function __construct()
    {
        $this->middleware('auth:api');
        
    }

    public function create(Request $request)
    { 
    	$ExperienceData=$request->data['schoolData'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($ExperienceData);

        $validator = Validator::make($myRequest->all(), [
            'school_name' => 'required|string|max:255',
            'education' => 'required|string|max:255', 
            'location_country' => 'required',
            'description' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|after_or_equal:start'
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

            $cv=CVSchool::firstOrCreate(
            	[
            		'user_id'=> $input['user_id'],
                    'school_name' => $input['school_name'],
                    'education' => $input['education'],
            	],
            	[
            		
            		'location_country' => $input['location_country']['id'],
            		'description' => $input['description'],
            		'start' => $input['start'],
            		'end' => $input['end'],
            		'key' => $input['key'],
            		

            	]
            );

    return response()->json(['success'=>'Added new records.'], 200); 
    }

    public function getThis()
    {
        $data=CVSchool::where('user_id',Auth::user()->id)->with('country')->orderby('end', 'desc')->where('status',1)->get();
        return response()->json($data, 200); 

    }

    public function getThisId($id)
    {
        $data=CVSchool::where('user_id',Auth::user()->id)->where('id',$id)->with('country')->orderby('end', 'desc')->first();
        return response()->json($data, 200); 

    }
    public function delete($id)
    {
        $data=CVSchool::where('id',$id)->update(['status'=>0]);
        
        return response()->json($data, 200); 
    }


    public function getAllData()
    {

    	$data =  CVSchool::with('users')->get();

        return response()->json($data, 200); 

    }

    
    public function update(Request $request,$id)
    { 
    	$ExperienceData=$request->data['experienceData'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($ExperienceData);

        $validator = Validator::make($myRequest->all(), [
            'education' => 'required|string|max:255',
            'school_name' => 'required|string|max:255', 
            'location_country' => 'required',
            'description' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|after_or_equal:start'
        ],
        [
     	
        ]
    	);
    if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()->all()], 422);            
            } 

         
    $input = $myRequest->all(); 
    if(isset($input['location_country']['id'])){
        $country=$input['location_country']['id'];
    }else{
        $country=$input['location_country'];
    }

            $cv=CVSchool::where('key',$id)
                ->update(
            	[
                    
                    'school_name' => $input['school_name'],
            		'education' => $input['education'],
            		'location_country' => $country,
            		'description' => $input['description'],
            		'start' => $input['start'],
            	]
            );

    return response()->json(['success'=>'Update records.'], 200); 
    }
}
