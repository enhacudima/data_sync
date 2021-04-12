<?php
namespace App\Http\Controllers\Helpers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Files;
use Auth;
use Storage;
use Illuminate\Support\Str;
use File;

class FilesController extends Controller
{
	public $key;

    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function filePictureReturn(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,jpg,png|max:5000',
        ],

        [

        ]
        );
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }
        $file_info=$this->getFile($request->file('picture'));
        return $file_info;

    }

    public function fileOtherFormatReturn(Request $request)
    {
        $validator = Validator::make($myRequest->all(), [
            'file' => 'required|mimes:pdf|max:5000',
        ],
        [

        ]
        );

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }
        $file_info=$this->getFile($request->file('file'));
        return $file_info;
    }

    public function filePicture(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'picture' => 'required|mimes:jpeg,jpg,png|max:5000',
        ],

        [

        ]
    	);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }
        $file_info=$this->getFile($request->file('picture'));
        return response()->json($file_info, 200);

    }

    public function fileOtherFormat(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,png,pdf,doc,docx|max:10000',
        ],
        [

        ]
    	);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }
        $file_info=$this->getFile($request->file('file'));
        return response()->json($file_info, 200);
    }



    public function getFile($file)
    {
    	$this->key=md5(time());
    	return $this->saveFile($file);

    }

        protected function saveFile($file)
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        // Group files by the date (week
        $dateFolder = date("Y-m-W");
        // Build the file path
        $filePath = "public/uploads/{$mime}/{$dateFolder}/";
        $filePathTable = "uploads/{$mime}/{$dateFolder}/";
        $finalPath = storage_path("app/".$filePath);
        // move the file name
        $check_file=$file->move($finalPath, $fileName);
        if($check_file){
            $last_id=$this->storeToTable($filePathTable,$fileName,$mime);
        }
        return [
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime,
            'file_id' =>$last_id
        ];
    }

    protected function createFilename($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension
        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;
        return $filename;
    }

    protected function storeToTable($path,$name,$mime_type)
    {
        $last_id=Files::create([
            "path" => $path,
            "name" => $name,
            "mime_type" => $mime_type,
            "key" => $this->key,
            //"user_id" =>Auth::user()->id
        ]);

        return $last_id->id;
    }

    public function useFile($file_id,$source_id, $table, $status)
    {
    	$data=Files::find($file_id);

	    if (isset($data)) {
            $data->table = $table;
            $data->source_id=$source_id;
	    	$data->status = $status;
            $data->user_id = Auth::user()->id;
	    	$data->save();
    	}

    	return "not_found";

    }

    public function deleteExcept($file_id,$source_id, $table)
    {
    	$data=Files::where("id","!=",$file_id)
            ->where('user_id',Auth::user()->id)
            ->where("source_id",$source_id)
            ->where("table",$table)
            ->get();


	    if (isset($data)) {
            foreach ($data as $key => $file) {
                $newFile=$file->path.$file->name;

                if(Storage::exists($newFile)){
                    Storage::delete($newFile);
                    Files::where("id","!=",$file->file_id)->delete();
                }else{
                    //dd(public_path($newFile));
                }
            }
    	}

    	return "not_found";

    }
}
