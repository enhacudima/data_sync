<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kitchen;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class KitchenController extends Controller
{
    
    public function createKitchen(Request $request)
    { 
    	$kitchen=$request->data['kitchen'];
        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($kitchen);

        $validator = Validator::make($myRequest->all(), [
            'type_stove' => 'required|string',
            'type_power_source' => 'required|string', 
            'back_up_gererator' => 'required|string',
            'grill_available' => 'required|string', 
            'user_id' => 'required|numeric|exists:users,id',
        ],
        [
     	
        ]
    	);
    if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()->all()], 422);            
    }      
       
    Kitchen::create([
        'type_stove' => $myRequest['type_stove'],
        'type_power_source' => $myRequest['type_power_source'],
        'back_up_gererator' => $myRequest['back_up_gererator'],
        'grill_available' =>$myRequest['grill_available'],
        'key' => md5(time()),
        'user_id' => $myRequest['user_id'],


    ]);

    return response()->json(['success'=>'Added new records.'], 200); 
    }


    public function getKitchen($user_id)
    {

    	$data =  Kitchen::where('kitchen_details.user_id',$user_id)
                            ->with('userKitchen')
                            ->get();

    return response()->json($data, 200); 

    }
}
