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
         $this->middleware('auth:api');
        $this->middleware('role_or_permission:admin_messages', ['only' => ['getMessages']]);

    }


    public function getMessages(){
        $data = Message::orderby('id','desc')->get();
        return response()->json($data, 200);
    }
}
