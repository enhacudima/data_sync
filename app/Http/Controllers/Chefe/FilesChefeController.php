<?php

namespace App\Http\Controllers\Chefe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CVFile;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class FilesChefeController extends Controller
{
     public $user_id; 
    
    public function __construct()
    {
        $this->middleware('auth:api');
        
    }

    public function create(Request $request)
    { 
    	$fileData=$request->data['fileData'];
        $fileInfo=$request->data['fileInfo'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($fileData);
        $myRequest->request->add(['file_id' => $fileInfo['file_id']]);



        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:45',
            'type' => 'required', 
            'file_id' => 'required',
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
            $input['type'] = $myRequest->type['id'];

            $cv=CVFile::create(
            	[
            		'user_id'=> $input['user_id'],
                    'key' => $input['key'],
                    'type' => $input['type'],
                    'name' => $input['name'],
                    'file_id' => $input['file_id'],
            	]
            );

            $file = new FilesController;
            $file_id = $input['file_id'];     
            $file->useFile($file_id, 'CV_File','', 0);

    return response()->json(['success'=>'Added new records.'], 200); 
    }

    public function getThis()
    {
        $data=CVFile::where('user_id',Auth::user()->id)->with('file_type','users','files')->orderby('updated_at', 'desc')->where('status',1)->get();
        return response()->json($data, 200); 

    }

    public function getThisId($key)
    {
        $data=CVFile::where('user_id',Auth::user()->id)->with('file_type','users','files')->orderby('updated_at', 'desc')->where('status',1)->where('key',$key)->first();
        return response()->json($data, 200); 

    }
    public function delete($key)
    {
        $data=CVFile::where('key',$key)->update(['status'=>0]);
        $data=CVFile::where('key',$key)->first();
        
        $file = new FilesController;
        $file_id = $data->file_id;     
        $file->useFile($file_id, 'CV_File','', 1);
        
        return response()->json($data, 200); 
    }


    public function getAllData()
    {

        $data=CVFile::where('user_id',Auth::user()->id)->with('file_type','users','files')->orderby('updated_at', 'desc')->where('status',1)->where('key',$key)->first();
        return response()->json($data, 200); 

    }


}
