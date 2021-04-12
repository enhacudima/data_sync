<?php

namespace App\Http\Controllers\Wellcome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Message;

class MessageController extends Controller
{

    public function sendMessage(Request $request)
    {
    	$messageData=$request->data['messageData'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($messageData);

        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:255',
        ],
        [

        ]
    	);
    if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()], 422);
            }

            $input = $myRequest->all();
            $Message=Message::Create(
            	[
            		'name'=> $input['name'],
            		'email' => $input['email'],
                    'message' => $input['message'],
            		'key' => md5(time()),
            	],
            );

    return response()->json(['success'=>'Message received successfully'], 200);
    }
}
