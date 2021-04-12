<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CommonTiming;

class CommonTimingController extends Controller
{
    
    public function getCommonTiming()
    {
    	$data=CommonTiming::all();
    	return response()->json($data, 200); 
    }
}
