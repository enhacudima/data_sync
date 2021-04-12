<?php

namespace App\Http\Controllers\Options;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Options;
use Auth;


class OptionsController extends Controller
{
    


    public function getOptions()
    {
        $data =  Options::select('name')->groupby('name')->get();

    return response()->json($data, 200); 

    }
}
