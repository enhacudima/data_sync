<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comments;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class CommentsController extends Controller
{
    
    public function createComments(Request $request)
    { 
    	$comment=$request->data['comment'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($comment);

        $validator = Validator::make($myRequest->all(), [
            'comment' => 'required|string',
            'parent_key' => 'nullable|string|exists:comments,key', 
            'source_id' => 'nullable|numeric',
            'table_name' => 'required|string', 
            'file' => 'nullable|mimes:jpeg,jpg,png|max:10000',//pictures
            'user_id' => 'required|numeric|exists:users,id',
        ],
        [
     	
        ]
    	);
    if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()->all()], 422);            
    }      


    $file_id = null;    
    if(isset($myRequest->file)){
        $file = new FilesController; 
        $file_info = $file->filePicture();
        $file_id = $file_info->file_id;      
        $file->useFile($file_id, 'comments', 0);

    }         
    Comments::create([
        'comment' => $myRequest['comment'],
        'parent_key' => $myRequest['parent_key'],
        'table_name' => $myRequest['table_name'],
        'file_id' =>$file_id,
        'source_id' =>$myRequest['source_id'],
        'key' => md5(time()),
        'user_id' => $myRequest['user_id'],


    ]);

    return response()->json(['success'=>'Added new records.'], 200); 
    }


    public function getComments($table, $source_id)
    {

    	$data =  Comments::where('comments.table_name',$table)
                            ->where('comments.source_id',$source_id)
                            ->where('parent_key',null)
                            ->with('fileComment','userComment','repliesComment','repliesComment.repliesComment','repliesComment.repliesComment.repliesComment')
                            ->get();

    return response()->json($data, 200); 

    }
}
