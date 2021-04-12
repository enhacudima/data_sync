<?php

namespace App\Http\Controllers\Chefe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CVContacts;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ReferencesController extends Controller
{
       
    public function __construct()
    {
        $this->middleware('auth:api');
        
    }

    public function create(Request $request)
    { 
    	$referenceDate=$request->data['referenceDate'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($referenceDate);

        $validator = Validator::make($myRequest->all(), [
            'linkedin' => 'required|url|max:255',
            're_1_email' => 'required|email|max:255', 
            're_1_phone' => 'required|numeric',
            're_1_name' => 'required|string|max:255',

            're_2_email' => 'nullable|email|max:255|different:re_1_email', 
            're_2_phone' => 'nullable|numeric|different:re_1_phone',
            're_2_name' => 'nullable|string|max:255|different:re_1_name',
        ],
        [
     	
        ]
    	);
    if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()->all()], 422);            
            } 
    $file = new FilesController; 
         
    $input = $myRequest->all(); 
    $input['user_id'] = Auth::user()->id; 
    $tempContact=CVContacts::where('user_id',Auth::user()->id)->first();
  
    if (isset($tempContact)){
        $input['key'] = $tempContact->key;
    }else{
        $input['key'] = md5(time()).Auth::user()->id;
    } 

            $cv=CVContacts::updateOrCreate(
            	[
            		'user_id'=> $input['user_id'],
            		'key' => $input['key'],
            	],
            	[
            		'linkedin' => $input['linkedin'],
            		're_1_phone' => $input['re_1_phone'],
            		're_1_email' => $input['re_1_email'],
            		're_1_name' => $input['re_1_name'],
            		're_2_phone' => $input['re_2_phone'],
            		're_2_email' => $input['re_2_email'],
            		're_2_name' => $input['re_2_name'],
            		

            	]
            );

    return response()->json(['success'=>'Added new records.'], 200); 
    }

    public function getData($id)
    {

    	$chefe_user_id = $id;
    	$data =  CVContacts::where('user_id',$chefe_user_id)
    		->first();

    return response()->json($data, 200); 

    }


    public function getAllData()
    {

    	$data =  CVContacts::get();

    return response()->json($data, 200); 

    }
}
