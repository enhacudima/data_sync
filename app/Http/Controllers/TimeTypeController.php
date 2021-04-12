<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeType;

class TimeTypeController extends Controller
{
    
    public function getTimeType()
    {
    	$data=TimeType::all();
    	return response()->json($data, 200); 
    }
}
