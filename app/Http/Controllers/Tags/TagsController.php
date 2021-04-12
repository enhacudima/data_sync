<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tags;
use Auth;


class TagsController extends Controller
{
    


    public function getTags($Tagstype)
    {

        $data =  Tags::select('tags.id','tags.name','tags.tags_type_id','tags_type.tag_type')
                    ->join('tags_type','tags_type.id','tags.tags_type_id')
                    ->where('tags_type.id',$Tagstype)
                    ->get();

    return response()->json($data, 200); 

    }
}
