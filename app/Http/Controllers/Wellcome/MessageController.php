<?php

namespace App\Http\Controllers\Wellcome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Message;

class MessageController extends Controller
{
    public function __construct()
    {

        $this->middleware('role_or_permission:admin_messages', ['only' => ['getMessages']]);

    }

    public function sendMessage(Request $request)
    {
    	$messageData=$request->data['messageData'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($messageData);

        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|numeric',
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
                    'phone' => $input['phone'],
                    'message' => $input['message'],
            		'key' => md5(time()),
            	],
            );

    return response()->json(['success'=>'Message received successfully'], 200);
    }
    public function getMessages(){
        $data = Message::orderby('id','desc')->get();
        return response()->json($data, 200);
    }
}
