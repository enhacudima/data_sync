<?php

namespace App\Http\Controllers\Cuisines;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cuisines;
use Auth;


class CuisinesController extends Controller
{
    


    public function getCuisines()
    {

    	$data =  Cuisines::with('pictureCuisines')
                            ->get();

    return response()->json($data, 200); 

    }
    
    public function getCuisinesV2()
    {

    	$data =  Cuisines::select('cuisines.*')
                        ->with('pictureCuisines')
                        ->join('meals','meals.cuisine_id','cuisines.id')
                        ->distinct()
                        ->get();

    return response()->json($data, 200); 

    }
}
