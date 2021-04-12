<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Http\Controllers\Helpers\FilesController;

class ToolsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api');

    }
    public function mode($mode) {
        $user_id=Auth::user()->id;
        if($mode=="true"){
            $m=1;
            $user = User::where('id',$user_id)->update(["mode"=>$m]);
        }else{
            $m=0;
            $user = User::where('id',$user_id)->update(["mode"=>$m]);
        }

        return response()->json(['success'=>'Success mode update.'], 200);
    }

        public function getMode() {
        $user_id=Auth::user()->id;
        $mode = User::where('id',$user_id)->select("mode")->first();
        return response()->json($mode->mode, 200);
    }

    public function getUserData(){
        $user_id=Auth::user()->id;
        $data = User::where('id',$user_id)->first();
        return response()->json($data, 200);
    }

    public function avatar (Request $request){
        $file= new FilesController();
        $file_id=$request->data['file_id'];
        $file->useFile($file_id, 'Avatar','Users', 0);
        $user_id=Auth::user()->id;
        $path=str_replace("public/","",$request->data['path']);
        $user = User::where('id',$user_id)->update(["avatar"=>$path.$request->data['name']]);
        $file->deleteExcept($file_id,'Avatar','Users');
    }


    public function abilities()
    {
        $data = Auth::user()->getPermissionNames();
        return response()->json($data,200);
    }

    public function locale($locale)
    {
        $user_id=Auth::user()->id;
        $user = User::where('id',$user_id)->update(["locale"=>$locale]);
        return response()->json(['success'=>'Success locale update.'], 200);

    }

}
